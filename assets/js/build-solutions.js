const initBuildSolutionsReveal = () => {
  const reveals = document.querySelectorAll('.build-solutions-page .reveal');
  if (!reveals.length) return;

  const reveal = () => {
    const windowHeight = window.innerHeight;
    const elementVisible = 100;

    reveals.forEach((el) => {
      const elementTop = el.getBoundingClientRect().top;
      if (elementTop < windowHeight - elementVisible) {
        el.classList.add('active');
      }
    });
  };

  window.addEventListener('scroll', reveal);
  reveal();
};

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initBuildSolutionsReveal);
} else {
  initBuildSolutionsReveal();
}
