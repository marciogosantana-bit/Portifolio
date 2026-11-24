<?php
// Recebe o formulário de contato, valida e grava no banco.
require_once __DIR__ . '/../config/database.php';

session_start();

// O JavaScript pede JSON; sem JS o navegador recebe um redirect.
$querJson = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'fetch';

function responder(bool $sucesso, string $mensagem, bool $querJson): void
{
    if ($querJson) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success'    => $sucesso,
            'message'    => $mensagem,
            'csrf_token' => $_SESSION['csrf_token'] ?? null,
        ]);
    } else {
        $_SESSION['flash'] = ['type' => $sucesso ? 'success' : 'error', 'message' => $mensagem];
        header('Location: ../index.php#contato');
    }
    exit;
}

// 1) Só aceita POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    responder(false, 'Método não permitido.', $querJson);
}

// 2) Honeypot: se o campo escondido veio preenchido, é robô. Finge sucesso.
if (!empty($_POST['website'])) {
    responder(true, 'Mensagem enviada com sucesso!', $querJson);
}

// 3) Token CSRF
$token = $_POST['csrf_token'] ?? '';
if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
    http_response_code(403);
    responder(false, 'Sessão expirada. Atualize a página e tente de novo.', $querJson);
}

// 4) Limite simples: 1 envio a cada 30 segundos por visitante
if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 30) {
    http_response_code(429);
    responder(false, 'Aguarde alguns segundos antes de enviar outra mensagem.', $querJson);
}

// 5) Limpeza e validação
$nome     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$mensagem = trim($_POST['message'] ?? '');

if ($nome === '' || $email === '' || $mensagem === '') {
    http_response_code(422);
    responder(false, 'Preencha todos os campos.', $querJson);
}
if (mb_strlen($nome) > 100 || mb_strlen($email) > 150 || mb_strlen($mensagem) > 2000) {
    http_response_code(422);
    responder(false, 'Algum campo ultrapassou o tamanho permitido.', $querJson);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    responder(false, 'Informe um e-mail válido.', $querJson);
}

// 6) Grava no banco (prepared statement = protege contra SQL Injection)
try {
    $pdo  = getConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO contatos (nome, email, mensagem, ip) VALUES (:nome, :email, :mensagem, :ip)'
    );
    $stmt->execute([
        ':nome'     => $nome,
        ':email'    => $email,
        ':mensagem' => $mensagem,
        ':ip'       => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);

    $_SESSION['ultimo_envio'] = time();
    $_SESSION['csrf_token']   = bin2hex(random_bytes(32)); // renova o token

    responder(true, 'Mensagem enviada com sucesso! Em breve retornarei o contato.', $querJson);
} catch (PDOException $e) {
    error_log('Erro ao salvar contato: ' . $e->getMessage()); // detalhe só no log do servidor
    http_response_code(500);
    responder(false, 'Não foi possível enviar sua mensagem agora. Tente novamente mais tarde.', $querJson);
}
