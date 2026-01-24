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
