const clientPortal = (() => {
  const titles = {
    home: 'Dashboard',
    support: 'Support Center',
    projects: 'Build Projects',
    websites: 'Websites',
    files: 'Files',
    billing: 'Billing',
  };

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

    const headerTitle = document.getElementById('headerTitle');
    if (headerTitle) {
      headerTitle.innerText = titles[viewId] || 'Dashboard';
    }
  };

  const openModal = () => {
    const modal = document.getElementById('ticketModal');
    if (modal) modal.classList.add('open');
  };

  const closeModal = () => {
    const modal = document.getElementById('ticketModal');
    if (modal) modal.classList.remove('open');
  };

  const loadTicket = (id) => {
    const items = document.querySelectorAll('body.client-portal-page .ticket-item');
    items.forEach((item) => item.classList.remove('selected'));
    if (items[id - 1]) {
      items[id - 1].classList.add('selected');
    }
  };

  return { nav, openModal, closeModal, loadTicket };
})();

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    window.clientPortal = clientPortal;
  });
} else {
  window.clientPortal = clientPortal;
}
