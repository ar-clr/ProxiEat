document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('dashboardWrapper');

    function showSkeleton() {
        if (!wrapper) return;
        wrapper.classList.remove('is-loaded');
        wrapper.classList.add('is-loading');
    }

    function showDashboard() {
        if (!wrapper) return;
        wrapper.classList.remove('is-loading');
        wrapper.classList.add('is-loaded');
    }

    function loadDashboard() {
        showSkeleton();

        setTimeout(function() {
            showDashboard();
        }, 1200);
    }

    if (wrapper) {
        loadDashboard();
    }

    const pets = document.querySelectorAll('.proxieat-selector__pet');
    const prevBtn = document.querySelector('.proxieat-selector__arrow--left');
    const nextBtn = document.querySelector('.proxieat-selector__arrow--right');

    if (!pets.length) return;

    let selectedIndex = 0;

    function updateCarousel() {
        const total = pets.length;
        const leftIndex = (selectedIndex - 1 + total) % total;
        const rightIndex = (selectedIndex + 1) % total;

        pets.forEach((pet, index) => {
            pet.classList.remove('is-selected', 'is-adjacent', 'is-far');
            pet.setAttribute('aria-selected', 'false');
            pet.style.order = '1';

            if (index === selectedIndex) {
                pet.classList.add('is-selected');
                pet.setAttribute('aria-selected', 'true');
            } else if (index === leftIndex) {
                pet.classList.add('is-adjacent');
                pet.style.order = '0';
            } else if (index === rightIndex) {
                pet.classList.add('is-adjacent');
                pet.style.order = '2';
            } else {
                pet.classList.add('is-far');
                pet.style.order = '3';
            }
        });
    }

    pets.forEach((pet, index) => {
        pet.addEventListener('click', function() {
            selectedIndex = index;
            updateCarousel();
        });

        pet.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                selectedIndex = index;
                updateCarousel();
            }
        });
    });

    prevBtn.addEventListener('click', function() {
        selectedIndex = (selectedIndex - 1 + pets.length) % pets.length;
        updateCarousel();
    });

    nextBtn.addEventListener('click', function() {
        selectedIndex = (selectedIndex + 1) % pets.length;
        updateCarousel();
    });

    updateCarousel();

    const heroGreeting = document.getElementById('heroGreeting');
    const heroSubtitle = document.getElementById('heroSubtitle');

    if (heroGreeting && heroSubtitle) {
        const messages = {
            luna: {
                greeting: '🐾 Luna is doing great today.',
                subtitle: 'See Luna\'s latest activities.'
            },
            mochi: {
                greeting: '🐾 Mochi is feeling cozy.',
                subtitle: 'Check on Mochi\'s recent moments.'
            },
            max: {
                greeting: '🐾 Max is ready for fun.',
                subtitle: 'See what Max has been up to.'
            }
        };

        const defaults = {
            greeting: '🐾 Your companion is waiting.',
            subtitle: 'Open Live Monitoring to see what your pet has been doing.'
        };

        function updateHeroMessage(index) {
            const petKey = pets[index] ? pets[index].getAttribute('data-pet') : null;
            const msg = petKey && messages[petKey] ? messages[petKey] : defaults;

            heroGreeting.style.opacity = '0';
            heroSubtitle.style.opacity = '0';

            setTimeout(function() {
                heroGreeting.textContent = msg.greeting;
                heroSubtitle.textContent = msg.subtitle;
                heroGreeting.style.opacity = '1';
                heroSubtitle.style.opacity = '1';
            }, 180);
        }

        heroGreeting.style.transition = 'opacity 200ms ease';
        heroSubtitle.style.transition = 'opacity 200ms ease';

        pets.forEach(function(pet, index) {
            pet.addEventListener('click', function() {
                updateHeroMessage(index);
            });

            pet.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    updateHeroMessage(index);
                }
            });
        });

        prevBtn.addEventListener('click', function() {
            setTimeout(function() {
                updateHeroMessage(selectedIndex);
            }, 180);
        });

        nextBtn.addEventListener('click', function() {
            setTimeout(function() {
                updateHeroMessage(selectedIndex);
            }, 180);
        });
    }
});
