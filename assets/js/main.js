(() => {
  const header = document.querySelector('.site-header');
  if (header) {
    const addShadow = () => {
      if (window.scrollY > 4) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };

    window.addEventListener('scroll', addShadow);
    addShadow();

    const navToggle = header.querySelector('.nav-toggle');
    const headerCollapse = header.querySelector('#header-collapse');

    if (navToggle && headerCollapse) {
      const setOpen = (open) => {
        header.classList.toggle('is-nav-open', open);
        navToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      };

      navToggle.addEventListener('click', () => {
        setOpen(!header.classList.contains('is-nav-open'));
      });

      headerCollapse.addEventListener('click', (event) => {
        const link = event.target.closest('a');
        if (link) setOpen(false);
      });

      window.addEventListener('resize', () => {
        if (window.matchMedia('(min-width: 768px)').matches) setOpen(false);
      });
    }
  }

  const filterWrapper = document.querySelector('[data-issue-filters]');
  if (filterWrapper) {
    const filterButtons = Array.from(filterWrapper.querySelectorAll('[data-filter]'));
    const cards = Array.from(document.querySelectorAll('.issue-detail-card[data-category]'));

    const applyFilter = (filter) => {
      cards.forEach((card) => {
        const matches = filter === 'all' || card.dataset.category === filter;
        card.hidden = !matches;
      });
    };

    filterButtons.forEach((button) => {
      button.addEventListener('click', () => {
        filterButtons.forEach((btn) => btn.classList.remove('is-active'));
        button.classList.add('is-active');
        applyFilter(button.dataset.filter);
      });
    });
  }

  const animatedItems = document.querySelectorAll('[data-animate]');
  if (!animatedItems.length) return;

  const reveal = (element) => {
    element.classList.add('is-visible');
  };

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          reveal(entry.target);
          observer.unobserve(entry.target);
        }
      });
    },
    {
      threshold: 0.15,
    }
  );

  animatedItems.forEach((item, index) => {
    item.style.transitionDelay = `${Math.min(index * 60, 240)}ms`;
    observer.observe(item);
  });
})();
