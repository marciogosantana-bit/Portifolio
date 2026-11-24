<?php
// Inicia a sessão e gera o token de segurança do formulário
require_once __DIR__ . '/includes/bootstrap.php';

$pageTitle = 'Márcio Gabriel | Desenvolvedor Full Stack em Formação';

require __DIR__ . '/includes/header.php';

require __DIR__ . '/includes/sections/hero.php';
require __DIR__ . '/includes/sections/sobre.php';
require __DIR__ . '/includes/sections/tecnologias.php';
require __DIR__ . '/includes/sections/projetos.php';
require __DIR__ . '/includes/sections/experiencia.php';
require __DIR__ . '/includes/sections/contato.php';

require __DIR__ . '/includes/footer.php';
