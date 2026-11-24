<!-- ===================== CONTATO ===================== -->
    <section id="contato" class="section contact">
      <div class="section-header" data-reveal="fade-in">
        <p class="section-eyebrow">Vamos conversar</p>
        <h2 class="section-title">Contato</h2>
      </div>

      <div class="contact-grid">
        <div class="contact-info" data-reveal="slide-right">
          <p class="contact-lead">
            Estou em busca da minha primeira oportunidade como desenvolvedor.
            Se você tem um projeto, vaga ou apenas quer trocar uma ideia sobre tecnologia,
            ficarei feliz em conversar.
          </p>

          <div class="contact-channels">
            <a href="mailto:seuemail@exemplo.com" class="contact-channel">
              <i class="fa-solid fa-envelope"></i>
              <div><span>Email</span><p>seuemail@exemplo.com</p></div>
            </a>
            <a href="https://wa.me/5500000000000" target="_blank" rel="noopener" class="contact-channel">
              <i class="fa-brands fa-whatsapp"></i>
              <div><span>WhatsApp</span><p>Vamos conversar</p></div>
            </a>
            <a href="#" target="_blank" rel="noopener" class="contact-channel">
              <i class="fa-brands fa-linkedin"></i>
              <div><span>LinkedIn</span><p>/in/marciogabriel</p></div>
            </a>
            <a href="#" target="_blank" rel="noopener" class="contact-channel">
              <i class="fa-brands fa-github"></i>
              <div><span>GitHub</span><p>/marciogabriel</p></div>
            </a>
            <a href="#" target="_blank" rel="noopener" class="contact-channel">
              <i class="fa-brands fa-instagram"></i>
              <div><span>Instagram</span><p>@mgabriel_oliveira.s</p></div>
            </a>
          </div>
        </div>

        <form class="contact-form" id="contact-form" method="post" action="actions/enviar_contato.php" data-reveal="slide-left" novalidate>
          <!-- Token CSRF: impede envios vindos de outros sites -->
          <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>" />

          <!-- Honeypot: campo invisível; robôs preenchem, pessoas não -->
          <div class="hp-field" aria-hidden="true">
            <label for="website">Não preencha este campo</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off" />
          </div>

          <div class="form-group">
            <input type="text" id="name" name="name" required maxlength="100" placeholder=" " />
            <label for="name">Nome</label>
          </div>
          <div class="form-group">
            <input type="email" id="email" name="email" required maxlength="150" placeholder=" " />
            <label for="email">Email</label>
          </div>
          <div class="form-group">
            <textarea id="message" name="message" rows="5" required maxlength="2000" placeholder=" "></textarea>
            <label for="message">Mensagem</label>
          </div>
          <button type="submit" class="btn btn-primary btn-block">
            <span>Enviar Mensagem</span> <i class="fa-regular fa-paper-plane"></i>
          </button>

          <?php
          // Retorno quando o navegador está sem JavaScript
          $flash = $_SESSION['flash'] ?? null;
          unset($_SESSION['flash']);
          ?>
          <p class="form-feedback <?= $flash ? htmlspecialchars($flash['type']) : '' ?>" id="form-feedback"><?= $flash ? htmlspecialchars($flash['message']) : '' ?></p>
        </form>
      </div>
    </section>
