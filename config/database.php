<?php
// Cria (uma única vez) a conexão com o MySQL usando PDO.
function getConnection(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $cfg = require __DIR__ . '/config.php';

        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};charset={$cfg['charset']}";

        $pdo = new PDO($dsn, $cfg['user'], $cfg['pass'], [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // erros viram exceções
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,                    // prepared statements reais
        ]);
    }

    return $pdo;
}
