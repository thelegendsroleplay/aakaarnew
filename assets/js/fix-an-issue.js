(() => {
  const filterWrapper = document.querySelector('[data-issue-filters]');
  if (!filterWrapper) return;

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
})();
