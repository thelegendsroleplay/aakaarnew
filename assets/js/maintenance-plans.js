/* =========================================
   1) REVEAL (IntersectionObserver)
========================================= */
const runMaintenancePlansScripts = () => {
  (function initReveal(){
    const els = document.querySelectorAll(".maintenance-plans-page .reveal");
    if (!els.length) return;
    if (!("IntersectionObserver" in window)) {
      els.forEach(el => el.classList.add("active"));
      return;
    }
    const io = new IntersectionObserver((entries) => {
      for (const entry of entries) {
        if (entry.isIntersecting) {
          entry.target.classList.add("active");
          io.unobserve(entry.target);
        }
      }
    }, { threshold: 0.12 });
    els.forEach(el => io.observe(el));
  })();

/* =========================================
   2) PRICING SPOTLIGHT (hover devices only)
========================================= */
  (function initSpotlight(){
    const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
    if (!canHover) return;

    const grid = document.querySelector(".maintenance-plans-page #pricing-grid");
    const cards = grid ? grid.querySelectorAll(".price-card") : [];
    if (!grid || !cards.length) return;

    let raf = null;
    let lastEvent = null;

    const update = () => {
      raf = null;
      if (!lastEvent) return;
      const e = lastEvent;
      cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        card.style.setProperty("--mouse-x", x + "px");
        card.style.setProperty("--mouse-y", y + "px");
      });
    };

    grid.addEventListener("mousemove", (e) => {
      lastEvent = e;
      if (!raf) raf = requestAnimationFrame(update);
    });
  })();

/* =========================================
   3) TYPEWRITER (safe: no innerHTML)
========================================= */
  (function initTypewriter(){
    const prefersReduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    const target = document.getElementById("typewriter-text");
    const section = document.getElementById("terminal-section");
    if (!target || !section) return;

    const text =
`// INCLUDED_TASKS (We Handle)
const fixPluginConflict = true;
const fixCssLayout = true;
const debugContactForm = true;
const wooCheckoutError = true;

// EXCLUDED_TASKS (Custom Quote)
const buildNewFeature = false;
const fullSiteRedesign = false;
const createCustomPlugin = false;

// NOTE: Major work is always quoted separately.`;

    if (prefersReduced) {
      target.textContent = text;
      return;
    }

    let i = 0;
    let started = false;

    const type = () => {
      const chunk = text.slice(i, i + 2);
      target.append(chunk);
      i += 2;
      if (i < text.length) setTimeout(type, 18);
    };

    if (!("IntersectionObserver" in window)) {
      type();
      return;
    }

    const io = new IntersectionObserver((entries) => {
      if (entries[0].isIntersecting && !started) {
        started = true;
        type();
        io.disconnect();
      }
    }, { threshold: 0.35 });

    io.observe(section);
  })();

/* =========================================
   4) FAQ ACCORDION (single-open)
========================================= */
  (function initFAQAccordion(){
    const acc = document.querySelector(".maintenance-plans-page .faq-accordion");
    if(!acc) return;

    const mode = acc.getAttribute("data-accordion") || "single"; // single | multi
    const items = Array.from(acc.querySelectorAll(".faq-item"));

    const closeItem = (item) => {
      const btn = item.querySelector(".faq-q");
      const panel = item.querySelector(".faq-a");
      item.classList.remove("is-open");
      btn.setAttribute("aria-expanded", "false");
      panel.style.height = "0px";
    };

    const openItem = (item) => {
      const btn = item.querySelector(".faq-q");
      const panel = item.querySelector(".faq-a");
      item.classList.add("is-open");
      btn.setAttribute("aria-expanded", "true");
      panel.style.height = panel.scrollHeight + "px";
    };

    items.forEach(item => closeItem(item));

    items.forEach(item => {
      const btn = item.querySelector(".faq-q");
      const panel = item.querySelector(".faq-a");

      btn.addEventListener("click", () => {
        const isOpen = item.classList.contains("is-open");

        if(mode === "single"){
          items.forEach(i => { if(i !== item) closeItem(i); });
        }

        if(isOpen) closeItem(item);
        else openItem(item);
      });

      window.addEventListener("resize", () => {
        if(item.classList.contains("is-open")){
          panel.style.height = panel.scrollHeight + "px";
        }
      });
    });
  })();
};

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", runMaintenancePlansScripts);
} else {
  runMaintenancePlansScripts();
}
