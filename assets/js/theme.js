(() => {
  const onReady = () => {
    const body = document.body;
    const toggle = document.querySelector('[data-mobile-menu-toggle]');
    const panel = document.querySelector('[data-mobile-menu-panel]');
    const overlay = document.querySelector('[data-mobile-menu-overlay]');
    const closeButtons = document.querySelectorAll('[data-mobile-menu-close]');

    let lastFocused = null;

    const openMenu = () => {
      if (!panel || !overlay) return;
      lastFocused = document.activeElement instanceof HTMLElement ? document.activeElement : null;
      body.classList.add('aakaari-mobile-open');
      panel.setAttribute('aria-hidden', 'false');
      overlay.setAttribute('aria-hidden', 'false');
      if (toggle) toggle.setAttribute('aria-expanded', 'true');

      const focusTarget = panel.querySelector('a, button');
      if (focusTarget instanceof HTMLElement) {
        setTimeout(() => focusTarget.focus({ preventScroll: true }), 120);
      }
    };

    const closeMenu = () => {
      if (!panel || !overlay) return;
      body.classList.remove('aakaari-mobile-open');
      panel.setAttribute('aria-hidden', 'true');
      overlay.setAttribute('aria-hidden', 'true');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
      if (lastFocused) {
        setTimeout(() => lastFocused.focus({ preventScroll: true }), 120);
      }
    };

    if (toggle) {
      toggle.addEventListener('click', (event) => {
        event.preventDefault();
        if (body.classList.contains('aakaari-mobile-open')) {
          closeMenu();
        } else {
          openMenu();
        }
      });
    }

    if (overlay) {
      overlay.addEventListener('click', closeMenu);
    }

    closeButtons.forEach((button) => {
      button.addEventListener('click', closeMenu);
    });

    window.addEventListener('keydown', (event) => {
      if (event.key === 'Escape') {
        closeMenu();
      }
    });

    const headerShell = document.querySelector('[data-header-shell]');
    if (headerShell) {
      const onScroll = () => {
        if (window.scrollY > 20) {
          headerShell.classList.remove('shadow-lg');
          headerShell.classList.add('shadow-xl', 'shadow-blue-500/10');
        } else {
          headerShell.classList.add('shadow-lg');
          headerShell.classList.remove('shadow-xl', 'shadow-blue-500/10');
        }
      };

      onScroll();
      window.addEventListener('scroll', onScroll, { passive: true });
    }
  };

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', onReady);
  } else {
    onReady();
  }
})();
