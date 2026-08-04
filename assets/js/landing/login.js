/* ==========================================================
   ProxiEat Login — Interactive Features
   ========================================================== */

(function () {
  'use strict';

  /* --------------------------------------------------------
     DOM REFERENCES
     -------------------------------------------------------- */

  const greetingText = document.getElementById('greetingText');
  const togglePassword = document.getElementById('togglePassword');
  const loginPassword = document.getElementById('loginPassword');
  const flashCardContainer = document.getElementById('flashCardContainer');
  const flashPrev = document.getElementById('flashPrev');
  const flashNext = document.getElementById('flashNext');
  const flashDots = document.getElementById('flashDots');
  const loginForm = document.getElementById('loginForm');
  const googleLoginBtn = document.getElementById('googleLoginBtn');
  const forgotPasswordLink = document.getElementById('forgotPasswordLink');
  const registerLink = document.getElementById('registerLink');

  /* --------------------------------------------------------
     GREETING ROTATION
     -------------------------------------------------------- */

  const GREETINGS = [
    'Welcome back!',
    'Your furry friend missed you.',
    'Ready to check on your pet?',
    "Let's make today another great day.",
    'Your companion is waiting.',
    'Hope your pet had a wonderful day.'
  ];

  const GREETING_STORAGE_KEY = 'proxiEat_greetingIndex';
  const GREETING_FADE_DURATION = 300;

  function getStoredIndex() {
    try {
      const stored = localStorage.getItem(GREETING_STORAGE_KEY);
      if (stored === null) return 0;
      const parsed = parseInt(stored, 10);
      if (Number.isNaN(parsed) || parsed < 0 || parsed >= GREETINGS.length) return 0;
      return parsed;
    } catch (e) {
      return 0;
    }
  }

  function storeIndex(index) {
    try {
      localStorage.setItem(GREETING_STORAGE_KEY, String(index));
    } catch (e) {
      /* localStorage unavailable — silently continue */
    }
  }

  function getNextIndex(currentIndex) {
    return (currentIndex + 1) % GREETINGS.length;
  }

  function showGreeting(index) {
    if (!greetingText) return;
    greetingText.style.opacity = '0';
    greetingText.style.transition = `opacity ${GREETING_FADE_DURATION}ms ease`;
    setTimeout(function () {
      greetingText.textContent = GREETINGS[index];
      greetingText.style.opacity = '1';
    }, GREETING_FADE_DURATION);
  }

  function initGreeting() {
    const currentIndex = getStoredIndex();
    showGreeting(currentIndex);
    storeIndex(getNextIndex(currentIndex));
  }

  /* --------------------------------------------------------
     PASSWORD VISIBILITY TOGGLE
     -------------------------------------------------------- */

  const EYE_OPEN = 'bi-eye';
  const EYE_CLOSED = 'bi-eye-slash';

  function isPasswordVisible() {
    if (!loginPassword) return false;
    return loginPassword.type === 'text';
  }

  function updateToggleIcon() {
    if (!togglePassword) return;
    const icon = togglePassword.querySelector('i');
    if (!icon) return;
    icon.className = isPasswordVisible() ? 'bi ' + EYE_CLOSED : 'bi ' + EYE_OPEN;
    togglePassword.setAttribute('aria-label', isPasswordVisible() ? 'Hide password' : 'Show password');
  }

  function togglePasswordVisibility() {
    if (!loginPassword) return;
    const cursorPos = loginPassword.selectionStart;
    loginPassword.type = isPasswordVisible() ? 'password' : 'text';
    loginPassword.setSelectionRange(cursorPos, cursorPos);
    updateToggleIcon();
  }

  /* --------------------------------------------------------
     FLASH CARDS
     -------------------------------------------------------- */

  const FLASH_CARDS = [
    {
      icon: 'bi bi-heart-pulse',
      theme: 'mint',
      category: 'Pet Care Tips',
      title: 'Daily Wellness Checks',
      description: 'Regular monitoring keeps your pet healthy and happy.',
      badges: ['Pet Tip', 'Smart Feeding']
    },
    {
      icon: 'bi bi-cat',
      theme: 'sky',
      category: 'Cat Facts',
      title: 'Purr-fect Sleepers',
      description: 'Cats sleep 16+ hours daily. Ensure their rest is comfortable.',
      badges: ['Cat Fact', 'Pet Tip']
    },
    {
      icon: 'bi bi-dog',
      theme: 'lavender',
      category: 'Dog Facts',
      title: 'Three Eyelids',
      description: 'Dogs have a third eyelid for protection and moisture.',
      badges: ['Dog Fact', 'Pet Tip']
    },
    {
      icon: 'bi bi-bell-fill',
      theme: 'peach',
      category: 'Smart Feeding Tips',
      title: 'Scheduled Meals',
      description: 'Consistent feeding times support digestion and weight management.',
      badges: ['Smart Feeding', 'AI Powered']
    },
    {
      icon: 'bi bi-camera-video',
      theme: 'cream',
      category: 'AI Monitoring Tips',
      title: 'Behavior Insights',
      description: 'AI detects subtle behavior changes early for better care.',
      badges: ['AI Powered', 'Real-time Monitoring']
    },
    {
      icon: 'bi bi-droplet-fill',
      theme: 'blush',
      category: 'Hydration Tips',
      title: 'Fresh Water Daily',
      description: 'Replace water bowls twice daily for optimal hydration.',
      badges: ['Pet Tip', 'Health Tips']
    },
    {
      icon: 'bi bi-lightbulb-fill',
      theme: 'mint',
      category: 'Grooming Tips',
      title: 'Regular Brushing',
      description: 'Brushing reduces shedding and helps detect skin issues early.',
      badges: ['Pet Tip', 'Health Tips']
    },
    {
      icon: 'bi bi-shield-check',
      theme: 'sky',
      category: 'Health Tips',
      title: 'Vaccination Tracker',
      description: 'Keep track of vet appointments and vaccination schedules.',
      badges: ['Health Tips', 'Real-time Monitoring']
    }
  ];

  const CARDS_PER_VIEW = 1;
  let currentCardIndex = 0;
  let autoRotateInterval = null;
  const AUTO_ROTATE_DELAY = 6000;

  /* --------------------------------------------------------
     FLASH CARD RENDERING
     -------------------------------------------------------- */

  function createCardElement(card) {
    const cardEl = document.createElement('div');
    cardEl.className = 'login-companion__card';
    cardEl.setAttribute('role', 'article');
    cardEl.setAttribute('aria-label', card.title);

    const iconEl = document.createElement('div');
    iconEl.className = 'login-companion__card-icon login-companion__card-icon--' + card.theme;
    iconEl.innerHTML = '<i class="' + card.icon + '"></i>';

    const categoryEl = document.createElement('span');
    categoryEl.className = 'login-companion__card-category';
    categoryEl.textContent = card.category;

    const titleEl = document.createElement('h3');
    titleEl.className = 'login-companion__card-title';
    titleEl.textContent = card.title;

    const descEl = document.createElement('p');
    descEl.className = 'login-companion__card-text';
    descEl.textContent = card.description;

    const badgesEl = document.createElement('div');
    badgesEl.className = 'login-companion__card-badges';

    if (card.badges && card.badges.length) {
      card.badges.forEach(function (badge) {
        const badgeEl = document.createElement('span');
        badgeEl.className = 'login-companion__card-badge';
        badgeEl.textContent = '✓ ' + badge;
        badgesEl.appendChild(badgeEl);
      });
    }

    cardEl.appendChild(iconEl);
    cardEl.appendChild(categoryEl);
    cardEl.appendChild(titleEl);
    cardEl.appendChild(descEl);
    cardEl.appendChild(badgesEl);

    return cardEl;
  }

  function renderCard(index, animationClass) {
    if (!flashCardContainer) return;
    const card = FLASH_CARDS[index];
    if (!card) return;

    flashCardContainer.innerHTML = '';

    const cardEl = createCardElement(card);
    if (animationClass) {
      cardEl.classList.add(animationClass);
    } else {
      cardEl.classList.add('login-companion__card--fade-in');
    }

    flashCardContainer.appendChild(cardEl);
    updateDots();
  }

  /* --------------------------------------------------------
     PAGINATION DOTS
     -------------------------------------------------------- */

  function createDots() {
    if (!flashDots) return;
    flashDots.innerHTML = '';
    FLASH_CARDS.forEach(function (_, i) {
      const dot = document.createElement('button');
      dot.className = 'login-companion__dot';
      dot.setAttribute('aria-label', 'Go to card ' + (i + 1));
      dot.setAttribute('type', 'button');
      dot.addEventListener('click', function () {
        goToCard(i);
      });
      flashDots.appendChild(dot);
    });
  }

  function updateDots() {
    if (!flashDots) return;
    const dots = flashDots.querySelectorAll('.login-companion__dot');
    dots.forEach(function (dot, i) {
      if (i === currentCardIndex) {
        dot.classList.add('login-companion__dot--active');
        dot.setAttribute('aria-current', 'true');
      } else {
        dot.classList.remove('login-companion__dot--active');
        dot.removeAttribute('aria-current');
      }
    });
  }

  /* --------------------------------------------------------
     NAVIGATION
     -------------------------------------------------------- */

  function getAnimationClass(direction) {
    if (direction === 'next') return 'login-companion__card--slide-left';
    if (direction === 'prev') return 'login-companion__card--slide-right';
    return 'login-companion__card--fade-in';
  }

  function goToCard(index, direction) {
    if (index < 0 || index >= FLASH_CARDS.length) return;
    currentCardIndex = index;
    renderCard(currentCardIndex, getAnimationClass(direction));
    resetAutoRotate();
  }

  function nextCard() {
    const next = (currentCardIndex + 1) % FLASH_CARDS.length;
    goToCard(next, 'next');
  }

  function prevCard() {
    const prev = (currentCardIndex - 1 + FLASH_CARDS.length) % FLASH_CARDS.length;
    goToCard(prev, 'prev');
  }

  /* --------------------------------------------------------
     AUTO ROTATE
     -------------------------------------------------------- */

  function startAutoRotate() {
    stopAutoRotate();
    autoRotateInterval = setInterval(nextCard, AUTO_ROTATE_DELAY);
  }

  function stopAutoRotate() {
    if (autoRotateInterval !== null) {
      clearInterval(autoRotateInterval);
      autoRotateInterval = null;
    }
  }

  function resetAutoRotate() {
    stopAutoRotate();
    startAutoRotate();
  }

  function pauseAutoRotate() {
    stopAutoRotate();
  }

  function resumeAutoRotate() {
    startAutoRotate();
  }

  /* --------------------------------------------------------
     KEYBOARD SUPPORT
     -------------------------------------------------------- */

  function handleKeyboard(e) {
    if (e.key === 'ArrowLeft') {
      e.preventDefault();
      prevCard();
    } else if (e.key === 'ArrowRight') {
      e.preventDefault();
      nextCard();
    }
  }

  /* --------------------------------------------------------
     EVENT BINDING
     -------------------------------------------------------- */

  function bindEvents() {
    if (togglePassword) {
      togglePassword.addEventListener('click', togglePasswordVisibility);
    }

    if (flashNext) {
      flashNext.addEventListener('click', function () {
        nextCard();
      });
    }

    if (flashPrev) {
      flashPrev.addEventListener('click', function () {
        prevCard();
      });
    }

    if (flashCardContainer) {
      flashCardContainer.addEventListener('mouseenter', pauseAutoRotate);
      flashCardContainer.addEventListener('mouseleave', resumeAutoRotate);
    }

    if (flashDots) {
      flashDots.addEventListener('mouseenter', pauseAutoRotate);
      flashDots.addEventListener('mouseleave', resumeAutoRotate);
    }

    document.addEventListener('keydown', handleKeyboard);

    if (googleLoginBtn) {
      googleLoginBtn.addEventListener('click', function () {
        /* Google login handler — to be implemented by backend */
      });
    }
  }

  registerLink.addEventListener('click', function () {
      window.location.href = 'register.php';
  });

  /* --------------------------------------------------------
     INITIALIZATION
     -------------------------------------------------------- */

  function init() {
    initGreeting();
    updateToggleIcon();
    createDots();
    renderCard(0, 'login-companion__card--fade-in');
    startAutoRotate();
    bindEvents();
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();