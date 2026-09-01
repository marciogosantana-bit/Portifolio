/* =========================================================
   PORTFÓLIO — Márcio Gabriel
   script.js
   Organização:
   1. Loading Screen
   2. Cursor personalizado
   3. Partículas de fundo (Canvas)
   4. Navbar (scroll + menu mobile)
   5. Dark / Light mode
   6. Texto digitando (typing effect)
   7. Scroll Reveal (Intersection Observer)
   8. Contadores animados
   9. Barras de progresso animadas
   10. Efeito ripple nos botões
   11. Botão voltar ao topo
   12. Formulário de contato
========================================================= */

document.addEventListener('DOMContentLoaded', () => {

  /* ===================== 1. LOADING SCREEN ===================== */
  const loadingScreen = document.getElementById('loading-screen');
  window.addEventListener('load', () => {
    setTimeout(() => {
      loadingScreen.classList.add('hidden');
    }, 900);
  });

  /* ===================== 2. CURSOR PERSONALIZADO ===================== */
  const cursorDot = document.querySelector('.cursor-dot');
  const cursorOutline = document.querySelector('.cursor-outline');
  const isTouchDevice = window.matchMedia('(hover: none), (pointer: coarse)').matches;

  if (!isTouchDevice && cursorDot && cursorOutline) {
    let outlineX = 0, outlineY = 0;

    window.addEventListener('mousemove', (e) => {
      cursorDot.style.left = `${e.clientX}px`;
      cursorDot.style.top = `${e.clientY}px`;
      outlineX = e.clientX;
      outlineY = e.clientY;
    });

    // Suaviza o movimento do círculo externo
    function animateOutline() {
      cursorOutline.style.left = `${outlineX}px`;
      cursorOutline.style.top = `${outlineY}px`;
      requestAnimationFrame(animateOutline);
    }
    animateOutline();

    const hoverTargets = document.querySelectorAll('a, button, .tech-card, .project-card, input, textarea');
    hoverTargets.forEach((el) => {
      el.addEventListener('mouseenter', () => cursorOutline.classList.add('cursor-hover'));
      el.addEventListener('mouseleave', () => cursorOutline.classList.remove('cursor-hover'));
    });
  }

  /* ===================== 3. PARTÍCULAS DE FUNDO ===================== */
  const canvas = document.getElementById('particles-canvas');
  const ctx = canvas.getContext('2d');
  let particles = [];

  function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
  }
  resizeCanvas();
  window.addEventListener('resize', resizeCanvas);

  class Particle {
    constructor() {
      this.reset();
    }
    reset() {
      this.x = Math.random() * canvas.width;
      this.y = Math.random() * canvas.height;
      this.radius = Math.random() * 1.8 + 0.6;
      this.speedX = (Math.random() - 0.5) * 0.3;
      this.speedY = (Math.random() - 0.5) * 0.3;
      this.color = Math.random() > 0.5 ? 'rgba(59, 130, 246, 0.55)' : 'rgba(124, 58, 237, 0.55)';
    }
    update() {
      this.x += this.speedX;
      this.y += this.speedY;
      if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
      if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
    }
    draw() {
      ctx.beginPath();
      ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
      ctx.fillStyle = this.color;
      ctx.fill();
    }
  }

  const particleCount = Math.min(80, Math.floor((canvas.width * canvas.height) / 18000));
  for (let i = 0; i < particleCount; i++) {
    particles.push(new Particle());
  }

  function connectParticles() {
    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx * dx + dy * dy);
        if (dist < 130) {
          ctx.beginPath();
          ctx.strokeStyle = `rgba(124, 58, 237, ${0.12 * (1 - dist / 130)})`;
          ctx.lineWidth = 1;
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
        }
      }
    }
  }

  function animateParticles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    particles.forEach((p) => {
      p.update();
      p.draw();
    });
    connectParticles();
    requestAnimationFrame(animateParticles);
  }
  animateParticles();

  /* ===================== 4. NAVBAR ===================== */
  const navbar = document.getElementById('navbar');
  const hamburger = document.getElementById('hamburger');
  const mobileMenu = document.getElementById('mobile-menu');
  const navLinks = document.querySelectorAll('.nav-link');
  const mobileLinks = document.querySelectorAll('.mobile-link');
  const backToTop = document.getElementById('back-to-top');

  function handleScrollUI() {
    const scrollY = window.scrollY;

    // Navbar sólida ao rolar
    navbar.classList.toggle('scrolled', scrollY > 60);

    // Botão voltar ao topo
    backToTop.classList.toggle('show', scrollY > 500);

    // Link ativo conforme a seção visível
    let currentSection = '';
    document.querySelectorAll('section[id]').forEach((section) => {
      const sectionTop = section.offsetTop - 140;
      if (scrollY >= sectionTop) {
        currentSection = section.getAttribute('id');
      }
    });

    navLinks.forEach((link) => {
      link.classList.toggle('active', link.getAttribute('href') === `#${currentSection}`);
    });
  }

  window.addEventListener('scroll', handleScrollUI);
  handleScrollUI();

  hamburger.addEventListener('click', () => {
    mobileMenu.classList.toggle('open');
    hamburger.classList.toggle('active');
  });

  mobileLinks.forEach((link) => {
    link.addEventListener('click', () => {
      mobileMenu.classList.remove('open');
    });
  });

  /* ===================== 5. DARK / LIGHT MODE ===================== */
  const themeToggle = document.getElementById('theme-toggle');
  const themeIcon = themeToggle.querySelector('i');

  function applyTheme(theme) {
    document.body.classList.toggle('light-mode', theme === 'light');
    themeIcon.className = theme === 'light' ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
  }

  // Usa a preferência salva nesta sessão (sem localStorage entre sessões do navegador)
  let currentTheme = 'dark';
  applyTheme(currentTheme);

  themeToggle.addEventListener('click', () => {
    currentTheme = currentTheme === 'dark' ? 'light' : 'dark';
    applyTheme(currentTheme);
  });

  /* ===================== 6. TEXTO DIGITANDO ===================== */
  const typingTarget = document.getElementById('typing-text');
  const words = ['HTML', 'CSS', 'JavaScript', 'Java', 'Spring Boot', 'MySQL'];
  let wordIndex = 0;
  let charIndex = 0;
  let isDeleting = false;

  function typeLoop() {
    const currentWord = words[wordIndex];

    if (isDeleting) {
      charIndex--;
    } else {
      charIndex++;
    }

    typingTarget.textContent = currentWord.substring(0, charIndex);

    let speed = isDeleting ? 60 : 110;

    if (!isDeleting && charIndex === currentWord.length) {
      speed = 1400;
      isDeleting = true;
    } else if (isDeleting && charIndex === 0) {
      isDeleting = false;
      wordIndex = (wordIndex + 1) % words.length;
      speed = 400;
    }

    setTimeout(typeLoop, speed);
  }
  typeLoop();

  /* ===================== 7. SCROLL REVEAL ===================== */
  const revealElements = document.querySelectorAll('[data-reveal]');

  const revealObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
          revealObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.15, rootMargin: '0px 0px -60px 0px' }
  );

  revealElements.forEach((el) => revealObserver.observe(el));

  /* ===================== 8. CONTADORES ANIMADOS ===================== */
  const statNumbers = document.querySelectorAll('.stat-number');

  function animateCounter(el) {
    const target = parseInt(el.getAttribute('data-target'), 10);
    const suffix = el.getAttribute('data-suffix') || '+';
    const duration = 1600;
    const startTime = performance.now();

    function update(now) {
      const progress = Math.min((now - startTime) / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3); // ease-out cubic
      const value = Math.floor(eased * target);
      el.textContent = value + (progress === 1 ? suffix : '');
      if (progress < 1) {
        requestAnimationFrame(update);
      }
    }
    requestAnimationFrame(update);
  }

  const statsObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          statsObserver.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.5 }
  );

  statNumbers.forEach((el) => statsObserver.observe(el));

  /* ===================== 9. BARRAS DE PROGRESSO ===================== */
  const techCards = document.querySelectorAll('.tech-card');

  const progressObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const card = entry.target;
          const level = card.getAttribute('data-level');
          const fill = card.querySelector('.progress-fill');
          setTimeout(() => {
            fill.style.width = `${level}%`;
          }, 200);
          progressObserver.unobserve(card);
        }
      });
    },
    { threshold: 0.3 }
  );

  techCards.forEach((card) => progressObserver.observe(card));

  /* ===================== 10. EFEITO RIPPLE ===================== */
  document.querySelectorAll('.btn').forEach((btn) => {
    btn.addEventListener('click', function (e) {
      const rect = this.getBoundingClientRect();
      const ripple = document.createElement('span');
      const size = Math.max(rect.width, rect.height);

      ripple.classList.add('ripple');
      ripple.style.width = ripple.style.height = `${size}px`;
      ripple.style.left = `${e.clientX - rect.left - size / 2}px`;
      ripple.style.top = `${e.clientY - rect.top - size / 2}px`;

      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });
  });

  /* ===================== 11. BOTÃO VOLTAR AO TOPO ===================== */
  backToTop.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });

  /* ===================== 12. FORMULÁRIO DE CONTATO ===================== */
  const contactForm = document.getElementById('contact-form');
  const formFeedback = document.getElementById('form-feedback');

  contactForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Aqui futuramente pode-se integrar com um serviço de envio de email
    // (ex: EmailJS, Formspree, ou uma API própria).
    formFeedback.textContent = 'Mensagem enviada com sucesso! Em breve retornarei o contato.';
    formFeedback.style.color = '#22C55E';
    contactForm.reset();

    setTimeout(() => {
      formFeedback.textContent = '';
    }, 5000);
  });

});
