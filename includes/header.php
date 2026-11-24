<?php
// Título da página (pode ser sobrescrito em index.php antes do include)
$pageTitle = $pageTitle ?? 'Márcio Gabriel | Desenvolvedor Full Stack em Formação';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="Portfólio de Márcio Gabriel, desenvolvedor Full Stack em formação. Projetos em HTML, CSS, JavaScript, Java e Spring Boot." />
  <meta name="keywords" content="desenvolvedor, full stack, portfolio, java, spring boot, javascript, html, css" />
  <meta name="author" content="Márcio Gabriel" />

  <!-- Open Graph / SEO básico -->
  <meta property="og:title" content="Márcio Gabriel | Desenvolvedor Full Stack" />
  <meta property="og:description" content="Construindo sites modernos e aplicações web Full Stack." />
  <meta property="og:type" content="website" />

  <!-- Google Fonts: Poppins -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

  <link rel="stylesheet" href="assets/css/style.css" />
</head>
<body>

  <!-- ===================== LOADING SCREEN ===================== -->
  <div id="loading-screen">
    <div class="loader-content">
      <div class="loader-logo">MG</div>
      <div class="loader-bar"><span></span></div>
      <p class="loader-text">Carregando experiência...</p>
    </div>
  </div>

  <!-- ===================== CURSOR PERSONALIZADO ===================== -->
  <div class="cursor-dot"></div>
  <div class="cursor-outline"></div>

  <!-- ===================== PARTÍCULAS DE FUNDO ===================== -->
  <canvas id="particles-canvas"></canvas>

  <!-- ===================== NAVBAR ===================== -->
  <header class="navbar" id="navbar">
    <div class="nav-container">
      <a href="#home" class="logo">
        <span class="logo-mark">MG</span>
        <span class="logo-name">Márcio Gabriel</span>
      </a>

      <nav class="nav-links" id="nav-links">
        <a href="#home" class="nav-link active">Home</a>
        <a href="#sobre" class="nav-link">Sobre</a>
        <a href="#projetos" class="nav-link">Projetos</a>
        <a href="#tecnologias" class="nav-link">Tecnologias</a>
        <a href="#experiencia" class="nav-link">Experiência</a>
        <a href="#contato" class="nav-link">Contato</a>
      </nav>

      <div class="nav-actions">
        <button class="theme-toggle" id="theme-toggle" aria-label="Alternar modo claro/escuro">
          <i class="fa-solid fa-moon"></i>
        </button>
        <a href="#contato" class="btn btn-primary nav-cta">Entrar em contato</a>
        <button class="hamburger" id="hamburger" aria-label="Abrir menu">
          <span></span><span></span><span></span>
        </button>
      </div>
    </div>

    <!-- Menu mobile -->
    <div class="mobile-menu" id="mobile-menu">
      <a href="#home" class="mobile-link">Home</a>
      <a href="#sobre" class="mobile-link">Sobre</a>
      <a href="#projetos" class="mobile-link">Projetos</a>
      <a href="#tecnologias" class="mobile-link">Tecnologias</a>
      <a href="#experiencia" class="mobile-link">Experiência</a>
      <a href="#contato" class="mobile-link">Contato</a>
      <a href="#contato" class="btn btn-primary">Entrar em contato</a>
    </div>
  </header>

  <main>
