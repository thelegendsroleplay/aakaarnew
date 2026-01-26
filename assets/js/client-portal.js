const clientPortal = (() => {
  const nav = (viewId, el) => {
    document.querySelectorAll('body.client-portal-page .view-section')
      .forEach((section) => section.classList.remove('active'));

    const target = document.getElementById(`view-${viewId}`);
    if (target) target.classList.add('active');

    if (el) {
      document.querySelectorAll('body.client-portal-page .nav-item')
        .forEach((item) => item.classList.remove('active'));
      el.classList.add('active');
    }
  };

  const openDetail = () => {
    nav('detail');
  };

  return { nav, openDetail };
})();

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.clientPortal = clientPortal;
  });
} else {
  window.clientPortal = clientPortal;
}
