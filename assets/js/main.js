(() => {
  const header = document.querySelector('.site-header');
  if (!header) return;

  const addShadow = () => {
    if (window.scrollY > 4) {
      header.classList.add('is-scrolled');
    } else {
      header.classList.remove('is-scrolled');
    }
  };

  window.addEventListener('scroll', addShadow);
  addShadow();
})();
