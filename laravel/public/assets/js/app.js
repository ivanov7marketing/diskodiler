const YM_COUNTER_ID = window.DISKODILER_METRIKA_ID || null;

function reachGoal(goal) {
  if (!goal) return;
  if (YM_COUNTER_ID && typeof window.ym === "function") {
    window.ym(YM_COUNTER_ID, "reachGoal", goal);
  }
}

function qs(selector, root = document) {
  return root.querySelector(selector);
}

function qsa(selector, root = document) {
  return [...root.querySelectorAll(selector)];
}

const WHATSAPP_URL = "https://wa.me/79669264666";
const PATH_PREFIX = window.DISKODILER_PATH_PREFIX || "";
const LEADS_ENDPOINT = window.DISKODILER_LEADS_ENDPOINT || null;

function withPathPrefix(path) {
  if (!path || /^(https?:|tel:|mailto:|#)/.test(path)) return path;
  return `${PATH_PREFIX}${path}`;
}

const sharedNavItems = [
  { page: "catalog", label: "Каталог", href: "diski/" },
  { page: "services", label: "Услуги", href: "services/" },
  { page: "delivery", label: "Доставка", href: "delivery/" },
  { page: "about", label: "О компании", href: "about.html" }
];

const sharedPageSettings = {
  home: {
    topline: "СПб • ул. Салова 27АД, офис 316",
    headerAction: { label: "Подобрать по VIN", modal: "vin-modal", goal: "header_vin_click" },
    stickyAction: { label: "Подобрать диски", modal: "vin-modal", goal: "sticky_mobile_vin" },
    footerText: "Оригинальные колеса, премиальные диски, подбор по VIN, шиномонтаж и доставка по России.",
    vinGoal: "vin_modal_submit",
    exitPopup: {
      title: "Сохраним подборку и цену?",
      text: "Оставьте телефон, и менеджер проверит OEM-комплект по VIN. Для первого заказа зафиксируем персональное предложение."
    }
  },
  catalog: {
    topline: "Склад + шиномонтаж: ул. Салова 31с3",
    headerAction: { label: "Подобрать по VIN", modal: "vin-modal", goal: "catalog_header_vin" },
    stickyAction: { label: "Подобрать диски", modal: "vin-modal", goal: "sticky_mobile_vin" },
    footerText: "Подбор оригинальных колес по VIN и заводским параметрам.",
    vinGoal: "vin_catalog_submit",
    exitPopup: {
      title: "Нужен точный OEM?",
      text: "Оставьте телефон — проверим по VIN и зафиксируем цену."
    }
  },
  product: {
    topline: "OEM BMW Group • гарантия 2 года",
    headerAction: { label: "Задать вопрос", href: WHATSAPP_URL, goal: "product_header_whatsapp" },
    stickyAction: { label: "Подобрать диски", modal: "vin-modal", goal: "sticky_product_vin" },
    footerText: "Оригинальные диски BMW, Mercedes, Porsche, Range Rover.",
    vinGoal: "vin_modal_submit",
    productLeadModals: true
  },
  services: {
    topline: "Шиномонтаж: ул. Салова 31с3",
    headerAction: { label: "Записаться", modal: "service-modal", goal: "service_header_book" },
    stickyAction: { label: "Записаться", modal: "service-modal", goal: "sticky_service_book" },
    footerText: "Сервис и продажа оригинальных колес в Санкт-Петербурге.",
    serviceGoal: "service_form_submit"
  },
  about: {
    topline: "Офис: ул. Салова 27АД, офис 316",
    headerAction: { label: "Подобрать по VIN", modal: "vin-modal", goal: "about_header_vin" },
    stickyAction: { label: "Подобрать диски", modal: "vin-modal", goal: "sticky_about_vin" },
    footerText: "© 2012–2026 ДискоДилер.",
    vinGoal: "about_vin_submit"
  },
  delivery: {
    topline: "Доставка по России и СНГ • самовывоз в Санкт-Петербурге",
    headerAction: { label: "Уточнить доставку", modal: "vin-modal", goal: "delivery_header_request" },
    stickyAction: { label: "Уточнить доставку", modal: "vin-modal", goal: "sticky_delivery_request" },
    footerText: "Доставка OEM-дисков и колес по Санкт-Петербургу, России и странам СНГ.",
    vinGoal: "delivery_vin_submit"
  },
  contacts: {
    topline: "Офис и склад в Санкт-Петербурге",
    headerAction: { label: "Задать вопрос", modal: "vin-modal", goal: "contacts_header_request" },
    stickyAction: { label: "Связаться", modal: "vin-modal", goal: "sticky_contacts_request" },
    footerText: "Контакты ДискоДилер: подбор OEM-дисков, склад, шиномонтаж и доставка.",
    vinGoal: "contacts_form_submit"
  },
  legal: {
    topline: "Документы и условия",
    headerAction: { label: "Подобрать по VIN", modal: "vin-modal", goal: "legal_header_vin" },
    stickyAction: { label: "Подобрать диски", modal: "vin-modal", goal: "sticky_legal_vin" },
    footerText: "Условия покупки, доставки, гарантии и обработки персональных данных.",
    vinGoal: "legal_vin_submit"
  },
  admin: {
    topline: "Прототип менеджерской зоны",
    headerAction: { label: "На сайт", href: "index.html", goal: "admin_to_site" },
    stickyAction: { label: "На сайт", href: "index.html", goal: "sticky_admin_to_site" },
    footerText: "Локальный прототип заявок для первого этапа Lean SEO MVP."
  },
  proposal: {
    topline: "Коммерческое предложение по развитию сайта",
    headerAction: { label: "Обсудить первый этап", href: WHATSAPP_URL, goal: "proposal_header_whatsapp" },
    stickyAction: { label: "Обсудить MVP", href: WHATSAPP_URL, goal: "proposal_sticky_whatsapp" },
    footerText: "Внутреннее коммерческое предложение: сравнение текущего сайта, Lean SEO MVP и полной архитектуры развития."
  }
};

function actionAttributes(action) {
  const goal = action.goal ? ` data-goal="${action.goal}"` : "";
  if (action.href) return `href="${withPathPrefix(action.href)}"${goal}`;
  return `type="button" data-open-modal="${action.modal}"${goal}`;
}

function actionTag(action, className = "btn") {
  const tag = action.href ? "a" : "button";
  return `<${tag} class="${className}" ${actionAttributes(action)}>${action.label}</${tag}>`;
}

function renderHeader(page, config) {
  const desktopNav = sharedNavItems.map((item) => {
    const current = item.page === page ? ' aria-current="page"' : "";
    return `<a href="${withPathPrefix(item.href)}"${current}>${item.label}</a>`;
  }).join("");
  const mobileNav = [
    { page: "home", label: "Главная", href: "index.html" },
    ...sharedNavItems,
    { label: "Позвонить", href: "tel:+79669264666" }
  ].filter((item) => item.page !== page).map((item) => `<a href="${withPathPrefix(item.href)}">${item.label}</a>`).join("");

  return `
    <header class="site-header">
      <div class="topline">
        <div class="container topline-inner">
          <span>${config.topline}</span>
          <a href="tel:+79669264666">+7 (966) 926-46-66</a>
        </div>
      </div>
      <div class="container header-inner">
        <a class="logo" href="${withPathPrefix("index.html")}" aria-label="ДискоДилер на главную">
          <img src="${withPathPrefix("assets/img/logo.webp")}" alt="ДискоДилер" width="88" height="88">
        </a>
        <nav class="nav" aria-label="Основная навигация">${desktopNav}</nav>
        <div class="header-actions">
          <button class="icon-btn" type="button" data-theme-toggle aria-label="Переключить тему">◐</button>
          ${actionTag(config.headerAction, "btn desktop-only")}
          <button class="menu-btn" type="button" data-menu-toggle aria-expanded="false" aria-controls="mobile-panel">Меню</button>
        </div>
      </div>
      <div class="mobile-panel" id="mobile-panel" data-mobile-panel>
        <nav aria-label="Мобильная навигация">${mobileNav}</nav>
      </div>
    </header>
  `;
}

function renderFooter(config) {
  return `
    <footer class="site-footer">
      <div class="container footer-grid">
        <div>
          <img class="footer-logo" src="${withPathPrefix("assets/img/logo.webp")}" alt="ДискоДилер" width="231" height="70" loading="lazy">
          <p class="small">${config.footerText}</p>
        </div>
        <div class="footer-links">
          <a href="tel:+79669264666">+7 (966) 926-46-66</a>
          <a href="${WHATSAPP_URL}" data-goal="footer_whatsapp">WhatsApp</a>
          <a href="mailto:shop@diskodiler.ru">shop@diskodiler.ru</a>
          <a href="${withPathPrefix("delivery/")}">Доставка</a>
          <a href="${withPathPrefix("warranty/")}">Гарантия</a>
          <a href="${withPathPrefix("privacy/")}">Политика данных</a>
          <span class="small">Офис: ул. Салова 27АД, офис 316</span>
          <span class="small">Склад + шиномонтаж: ул. Салова 31с3</span>
        </div>
      </div>
    </footer>
  `;
}

function renderFloating(config) {
  return `
    <div class="chat-bubble" aria-label="Быстрая связь">
      <a href="${WHATSAPP_URL}" aria-label="Написать в WhatsApp" data-goal="chat_whatsapp"><img src="${withPathPrefix("assets/img/messengers/icon-whatsapp.png")}" alt="" loading="lazy"></a>
      <button type="button" aria-label="Telegram пока не указан" data-open-modal="contact-modal" data-goal="chat_telegram_fallback"><img src="${withPathPrefix("assets/img/messengers/icon-telegram.png")}" alt="" loading="lazy"></button>
      <button type="button" aria-label="Max пока не указан" data-open-modal="contact-modal" data-goal="chat_max_fallback"><img src="${withPathPrefix("assets/img/messengers/icon-max.png")}" alt="" loading="lazy"></button>
    </div>
    <div class="sticky-mobile-cta">${actionTag(config.stickyAction)}</div>
  `;
}

function renderVinModal(config) {
  if (!config.vinGoal) return "";
  return `
    <div class="modal" id="vin-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="vin-modal-title">
      <div class="modal-card">
        <div class="modal-head">
          <div><h2 id="vin-modal-title">Проверка по VIN</h2><p class="small">Сверим совместимость и OEM-артикулы.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <form data-vin-form data-goal="${config.vinGoal}">
          <input class="input" name="vin" placeholder="VIN или модель автомобиля" autocomplete="off">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
          <button class="btn" type="submit">Отправить на проверку</button>
        </form>
        <div class="notice" role="status"></div>
      </div>
    </div>
  `;
}

function renderContactModal() {
  return `
    <div class="modal" id="contact-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="contact-modal-title">
      <div class="modal-card">
        <div class="modal-head">
          <div><h2 id="contact-modal-title">Telegram уточняется</h2><p class="small">Пока быстрый канал связи — WhatsApp или телефон.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <a class="btn" href="${WHATSAPP_URL}" data-goal="telegram_fallback_whatsapp">Написать в WhatsApp</a>
      </div>
    </div>
  `;
}

function renderServiceModal(config) {
  if (!config.serviceGoal) return "";
  return `
    <div class="modal" id="service-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="service-modal-title">
      <div class="modal-card">
        <div class="modal-head">
          <div><span class="section-kicker">Запись на сервис</span><h2 id="service-modal-title">Уточним время и размер</h2><p class="small">Оставьте контакты, диаметр и тип шин. Менеджер подтвердит свободное время.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <form data-lead-form data-goal="${config.serviceGoal}">
          <textarea class="textarea" name="message" placeholder="Например: BMW X5 G05, R20, RunFlat, нужно переобуть комплект"></textarea>
          <select class="select" name="contactMethod" aria-label="Удобный способ связи">
            <option value="Telegram">Telegram</option>
            <option value="Max">Max</option>
            <option value="Звонок">Звонок</option>
          </select>
          <div class="lead-fields-row">
            <input class="input" name="name" placeholder="Ваше имя" autocomplete="name">
            <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
          </div>
          <button class="btn" type="submit">Записаться</button>
        </form>
        <div class="notice" role="status"></div>
      </div>
    </div>
  `;
}

function renderProductLeadModals(config) {
  if (!config.productLeadModals) return "";

  const contactMethods = `
    <div class="contact-method-options" role="radiogroup" aria-label="Удобный способ связи">
      <label><input type="radio" name="contactMethod" value="Telegram" required checked><span>Telegram</span></label>
      <label><input type="radio" name="contactMethod" value="Max" required><span>Max</span></label>
      <label><input type="radio" name="contactMethod" value="Позвонить" required><span>Позвонить</span></label>
    </div>
  `;

  return `
    <div class="modal" id="product-reserve-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="product-reserve-modal-title">
      <div class="modal-card">
        <div class="modal-head">
          <div><h2 id="product-reserve-modal-title">Забронировать комплект</h2><p class="small">Оставьте контакты, менеджер подтвердит наличие и условия резерва.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <form data-lead-form data-goal="product_reserve_submit">
          <input type="hidden" name="requestType" value="Забронировать">
          <input type="hidden" name="message" value="Забронировать комплект">
          <fieldset class="contact-method-field">
            <legend>Удобный способ связи</legend>
            ${contactMethods}
          </fieldset>
          <div class="lead-fields-row">
            <input class="input" name="name" placeholder="Имя" autocomplete="name" required>
            <input class="input" name="phone" placeholder="Номер телефона" autocomplete="tel" required>
          </div>
          <button class="btn" type="submit">Отправить заявку</button>
        </form>
        <div class="notice" role="status"></div>
      </div>
    </div>
    <div class="modal" id="product-details-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="product-details-modal-title">
      <div class="modal-card">
        <div class="modal-head">
          <div><h2 id="product-details-modal-title">Уточнить детали</h2><p class="small">Спросите про состояние, доставку, OEM или совместимость.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <form data-lead-form data-goal="product_details_submit">
          <input type="hidden" name="requestType" value="Уточнить детали">
          <textarea class="textarea" name="message" placeholder="Ваш вопрос" required></textarea>
          <fieldset class="contact-method-field">
            <legend>Удобный способ связи</legend>
            ${contactMethods}
          </fieldset>
          <div class="lead-fields-row">
            <input class="input" name="name" placeholder="Имя" autocomplete="name" required>
            <input class="input" name="phone" placeholder="Номер телефона" autocomplete="tel" required>
          </div>
          <button class="btn" type="submit">Отправить вопрос</button>
        </form>
        <div class="notice" role="status"></div>
      </div>
    </div>
  `;
}

function renderExitPopup(config) {
  if (!config.exitPopup) return "";
  return `
    <div class="exit-popup" data-exit-popup>
      <div class="exit-card">
        <h2>${config.exitPopup.title}</h2>
        <p class="small">${config.exitPopup.text}</p>
        <form data-lead-form data-goal="exit_discount_submit" class="stack-form">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
          <button class="btn" type="submit">Получить предложение</button>
          <button class="btn secondary" type="button" data-close-exit>Не сейчас</button>
        </form>
        <div class="notice" role="status"></div>
      </div>
    </div>
  `;
}

function renderSharedLayout() {
  const page = document.body.dataset.page || "home";
  const config = sharedPageSettings[page] || sharedPageSettings.home;
  const header = qs("[data-shared-header]");
  const footer = qs("[data-shared-footer]");
  const floating = qs("[data-shared-floating]");
  const modals = qs("[data-shared-modals]");

  if (header) header.outerHTML = renderHeader(page, config);
  if (footer) footer.outerHTML = renderFooter(config);
  if (floating) floating.outerHTML = renderFloating(config);
  if (modals) {
    modals.outerHTML = [
      renderVinModal(config),
      renderContactModal(),
      renderServiceModal(config),
      renderProductLeadModals(config),
      renderExitPopup(config)
    ].join("");
  }
}

function initTheme() {
  const saved = localStorage.getItem("diskodiler-theme");
  if (saved) document.documentElement.dataset.theme = saved;
  qsa("[data-theme-toggle]").forEach((button) => {
    if (button.dataset.ready === "true") return;
    button.dataset.ready = "true";
    button.addEventListener("click", () => {
      const next = document.documentElement.dataset.theme === "light" ? "dark" : "light";
      document.documentElement.dataset.theme = next;
      localStorage.setItem("diskodiler-theme", next);
      button.setAttribute("aria-label", next === "light" ? "Включить темную тему" : "Включить светлую тему");
    });
  });
}

function initMenu() {
  const button = qs("[data-menu-toggle]");
  const panel = qs("[data-mobile-panel]");
  if (!button || !panel) return;
  button.addEventListener("click", () => {
    const isOpen = panel.classList.toggle("is-open");
    button.setAttribute("aria-expanded", String(isOpen));
  });
  qsa("a", panel).forEach((link) => {
    link.addEventListener("click", () => {
      panel.classList.remove("is-open");
      button.setAttribute("aria-expanded", "false");
    });
  });
}

function initGoals() {
  qsa("[data-goal]").forEach((item) => {
    if (item.dataset.goalReady === "true") return;
    item.dataset.goalReady = "true";
    item.addEventListener("click", () => reachGoal(item.dataset.goal));
  });
}

function openModal(id) {
  const modal = document.getElementById(id);
  if (!modal) return;
  modal.classList.add("is-open");
  modal.setAttribute("aria-hidden", "false");
  const focusable = qs("input, button, textarea, select, a", modal);
  if (focusable) focusable.focus();
}

function closeModal(modal) {
  modal.classList.remove("is-open");
  modal.setAttribute("aria-hidden", "true");
}

function initModals() {
  qsa("[data-open-modal]").forEach((button) => {
    if (button.dataset.modalReady === "true") return;
    button.dataset.modalReady = "true";
    button.addEventListener("click", () => openModal(button.dataset.openModal));
  });
  qsa("[data-close-modal]").forEach((button) => {
    if (button.dataset.modalCloseReady === "true") return;
    button.dataset.modalCloseReady = "true";
    button.addEventListener("click", () => closeModal(button.closest(".modal")));
  });
  qsa(".modal").forEach((modal) => {
    if (modal.dataset.backdropReady === "true") return;
    modal.dataset.backdropReady = "true";
    modal.addEventListener("click", (event) => {
      if (event.target === modal) closeModal(modal);
    });
  });
  document.addEventListener("keydown", (event) => {
    if (event.key !== "Escape") return;
    qsa(".modal.is-open").forEach(closeModal);
    qs("[data-exit-popup]")?.classList.remove("is-open");
  });
}

function normalizeVin(value) {
  return value.trim().toUpperCase().replace(/[^A-Z0-9]/g, "");
}

const LEADS_KEY = "diskodiler-leads";

function formDataToObject(form) {
  const data = {};
  const formData = new FormData(form);

  formData.forEach((value, key) => {
    if (Object.prototype.hasOwnProperty.call(data, key)) {
      data[key] = Array.isArray(data[key]) ? [...data[key], value] : [data[key], value];
    } else {
      data[key] = value;
    }
  });

  return data;
}

function collectUtm() {
  const params = new URLSearchParams(window.location.search);
  return Object.fromEntries([...params.entries()].filter(([key]) => key.startsWith("utm_") || key === "yclid" || key === "gclid"));
}

function readLeadSubmissions() {
  try {
    return JSON.parse(localStorage.getItem(LEADS_KEY) || "[]");
  } catch {
    return [];
  }
}

function saveLeadSubmission(type, form, extra = {}) {
  const lead = {
    id: `lead-${Date.now()}-${Math.random().toString(16).slice(2)}`,
    createdAt: new Date().toISOString(),
    status: "new",
    type,
    goal: form?.dataset.goal || extra.goal || "",
    page: window.location.pathname || "/",
    title: document.title,
    fields: form ? formDataToObject(form) : {},
    utm: collectUtm(),
    ...extra
  };

  try {
    localStorage.setItem(LEADS_KEY, JSON.stringify([lead, ...readLeadSubmissions()].slice(0, 100)));
  } catch {
    // В статичном прототипе это запасной слой. На Laravel заявки уйдут в БД.
  }

  if (LEADS_ENDPOINT) {
    const csrf = qs('meta[name="csrf-token"]')?.getAttribute("content") || "";
    fetch(LEADS_ENDPOINT, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": csrf
      },
      body: JSON.stringify(lead),
      keepalive: true
    }).catch(() => {});
  }

  return lead;
}

function showLeadSuccess(form) {
  const modal = form.closest(".modal");
  const modalCard = form.closest(".modal-card");

  if (!modal || !modalCard) return false;

  modalCard.innerHTML = `
    <div class="modal-success">
      <h2>Заявка отправлена</h2>
      <p class="lead">Благодарим за проявленный интерес! Мы свяжемся с вами в ближайшее рабочее время</p>
      <button class="btn" type="button" data-close-modal>Закрыть</button>
    </div>
  `;

  const closeButton = qs("[data-close-modal]", modalCard);
  closeButton?.addEventListener("click", () => closeModal(modal));
  closeButton?.focus();

  return true;
}

function initForms() {
  qsa("[data-vin-form]").forEach((form) => {
    const notice = qs(".notice", form.closest(".vin-widget, .vin-panel, .modal-card") || document);
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      const input = qs("[name='vin']", form);
      const vin = normalizeVin(input?.value || "");
      if (vin.length < 7) {
        input?.setAttribute("aria-invalid", "true");
        input?.focus();
        return;
      }
      input?.removeAttribute("aria-invalid");
      saveLeadSubmission("vin_selection", form, { vin });
      reachGoal(form.dataset.goal || "vin_submit");
      if (notice) {
        notice.textContent = "Заявка сохранена. Менеджер проверит комплектацию, OEM-артикулы и совместимость по вылету/PCD.";
        notice.classList.add("is-visible");
      }
    });
  });

  qsa("[data-lead-form]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      if (!form.checkValidity()) {
        form.reportValidity();
        return;
      }
      saveLeadSubmission("lead", form);
      reachGoal(form.dataset.goal || "lead_submit");
      if (showLeadSuccess(form)) return;

      const notice = qs(".notice", form.parentElement);
      if (notice) {
        notice.textContent = "Благодарим за проявленный интерес! Мы свяжемся с вами в ближайшее рабочее время";
        notice.classList.add("is-visible");
      }
    });
  });
}

const quizModelsByBrand = {
  BMW: ["X1", "X3 G01", "X4 G02", "X5 G05", "X6 G06", "X7 G07", "3 / 4 G20", "5 G30", "M3 / M4 G80"],
  "Mercedes-Benz": ["C-Class", "E-Class", "S-Class", "GLC", "GLE W167", "GLS", "AMG GT"],
  Porsche: ["Macan", "Cayenne", "Panamera", "911", "Taycan"],
  "Range Rover": ["Evoque", "Velar", "Sport", "Vogue", "Defender", "Discovery"],
  Lamborghini: ["Urus", "Huracan", "Aventador"],
  "Rolls-Royce": ["Cullinan", "Ghost", "Phantom", "Wraith"],
  RAM: ["1500", "1500 TRX", "Limited", "Rebel"]
};

function initWheelQuiz() {
  qsa("[data-wheel-quiz]").forEach((form) => {
    if (form.dataset.quizReady === "true") return;
    form.dataset.quizReady = "true";
    form.noValidate = true;

    const steps = qsa("[data-quiz-step]", form);
    const prevButton = qs("[data-quiz-prev]", form);
    const nextButton = qs("[data-quiz-next]", form);
    const submitButton = qs("[data-quiz-submit]", form);
    const progress = qs("[data-quiz-progress]", form);
    const progressRoot = progress?.parentElement;
    const progressLabel = qs("b", progressRoot);
    const percent = qs("[data-quiz-percent]", form);
    const notice = qs(".notice", form);
    const progressValues = ["6%", "40%", "60%", "80%", "100%"];
    const brandSelect = qs("[data-quiz-brand]", form);
    const modelSelect = qs("[data-quiz-model]", form);
    const phoneInput = qs("[data-quiz-phone]", form);
    let current = 0;

    function option(value, label = value) {
      return `<option value="${value}">${label}</option>`;
    }

    function populateBrands() {
      if (!brandSelect) return;
      brandSelect.innerHTML = option("", "Выберите МАРКУ") + Object.keys(quizModelsByBrand).map((brand) => option(brand)).join("");
    }

    function populateModels(brand) {
      if (!modelSelect) return;
      const models = quizModelsByBrand[brand] || [];
      modelSelect.innerHTML = option("", "Выберите МОДЕЛЬ") + models.map((model) => option(model)).join("");
      modelSelect.disabled = models.length === 0;
    }

    function selectedRadio(name) {
      return qs(`[name="${name}"]:checked`, form);
    }

    function hasChecked(name) {
      return qsa(`[name="${name}"]:checked`, form).length > 0;
    }

    function formatPhone(value) {
      let digits = value.replace(/\D/g, "");
      if (digits.startsWith("8")) digits = `7${digits.slice(1)}`;
      if (!digits.startsWith("7")) digits = `7${digits}`;
      digits = digits.slice(0, 11);

      const city = digits.slice(1, 4);
      const first = digits.slice(4, 7);
      const second = digits.slice(7, 9);
      const third = digits.slice(9, 11);

      let formatted = "+7";
      if (city) formatted += ` (${city}`;
      if (city.length === 3) formatted += ")";
      if (first) formatted += ` ${first}`;
      if (second) formatted += `-${second}`;
      if (third) formatted += `-${third}`;

      return formatted;
    }

    function syncPhoneMask() {
      if (!phoneInput || !phoneInput.value.trim()) return;
      phoneInput.value = formatPhone(phoneInput.value);
    }

    function updateOptionStates() {
      qsa("[data-quiz-option]", form).forEach((option) => {
        const input = qs("input", option);
        option.classList.toggle("is-selected", Boolean(input?.checked));
      });
    }

    function markStep(step, invalid) {
      qsa("input, textarea, select", step).forEach((field) => {
        const isChoice = field.type === "checkbox" || field.type === "radio";
        if (isChoice) return;
        const shouldMark = invalid && field.required && !field.value.trim();
        field.toggleAttribute("aria-invalid", shouldMark);
      });
    }

    function isStepValid(index, shouldMark = false) {
      const step = steps[index];
      if (!step) return false;

      let valid = true;
      if (index === 0) {
        valid = Boolean(qs("[name='brand']", step)?.value) && Boolean(qs("[name='model']", step)?.value);
      }
      if (index === 1) valid = hasChecked("diameter");
      if (index === 2) valid = Boolean(selectedRadio("tires"));
      if (index === 3) valid = Boolean(qs("[name='city']", step)?.value.trim());
      if (index === 4) {
        syncPhoneMask();
        const name = qs("[name='name']", step);
        const phone = qs("[name='phone']", step);
        const consent = qs("[name='consent']", step);
        const phoneDigits = phone?.value.replace(/\D/g, "") || "";
        valid = Boolean(name?.value.trim()) && phoneDigits.length === 11 && Boolean(consent?.checked);
      }

      if (shouldMark) markStep(step, !valid);
      return valid;
    }

    function updateControls() {
      const finalStep = current === steps.length - 1;
      const valid = isStepValid(current);
      prevButton.hidden = current === 0;
      nextButton.hidden = finalStep;
      submitButton.hidden = !finalStep;
      nextButton.disabled = !valid;
      submitButton.disabled = !valid;
    }

    function showStep(index) {
      current = Math.max(0, Math.min(index, steps.length - 1));
      form.classList.toggle("is-first-step", current === 0);
      form.classList.toggle("is-final-step", current === steps.length - 1);
      steps.forEach((step, stepIndex) => {
        const active = stepIndex === current;
        step.hidden = !active;
        step.classList.toggle("is-active", active);
      });
      const value = progressValues[current] || "100%";
      progressRoot?.style.setProperty("--quiz-progress", value);
      progressLabel?.setAttribute("data-progress-label", value);
      if (percent) percent.textContent = value;
      notice?.classList.remove("is-visible");
      updateOptionStates();
      updateControls();
    }

    qsa("input, textarea", form).forEach((field) => {
      field.addEventListener("input", () => {
        field.removeAttribute("aria-invalid");
        if (field.matches("[data-quiz-phone]")) syncPhoneMask();
        updateControls();
      });
      field.addEventListener("change", () => {
        if (field.matches("[data-quiz-phone]")) syncPhoneMask();
        updateOptionStates();
        updateControls();
      });
    });

    brandSelect?.addEventListener("change", () => {
      populateModels(brandSelect.value);
      brandSelect.removeAttribute("aria-invalid");
      modelSelect?.removeAttribute("aria-invalid");
      updateControls();
    });

    modelSelect?.addEventListener("change", () => {
      modelSelect.removeAttribute("aria-invalid");
      updateControls();
    });

    nextButton.addEventListener("click", () => {
      if (!isStepValid(current, true)) {
        updateControls();
        return;
      }
      showStep(current + 1);
    });

    prevButton.addEventListener("click", () => showStep(current - 1));

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      if (!isStepValid(current, true)) {
        updateControls();
        return;
      }
      saveLeadSubmission("wheel_quiz", form);
      reachGoal("wheel_quiz_submit");
      if (notice) {
        notice.textContent = "Заявка сохранена. Менеджер подготовит подборку дисков и свяжется с вами.";
        notice.classList.add("is-visible");
      }
      submitButton.disabled = true;
    });

    populateBrands();
    populateModels(brandSelect?.value || "");
    showStep(0);
  });
}

function initLeadsAdmin() {
  const root = qs("[data-leads-admin]");
  if (!root) return;

  function fieldSummary(lead) {
    const fields = lead.fields || {};
    return [
      fields.name && `Имя: ${fields.name}`,
      fields.phone && `Телефон: ${fields.phone}`,
      fields.telegram && `Telegram: ${fields.telegram}`,
      fields.vin && `VIN: ${fields.vin}`,
      fields.brand && `Марка: ${fields.brand}`,
      fields.model && `Модель: ${fields.model}`,
      fields.city && `Город: ${fields.city}`,
      fields.message && `Комментарий: ${fields.message}`
    ].filter(Boolean).join("; ") || "Данные формы не заполнены";
  }

  function render() {
    const leads = readLeadSubmissions();
    root.innerHTML = leads.length
      ? `
        <div class="catalog-toolbar">
          <strong>${leads.length} заявок в локальном прототипе</strong>
          <button class="btn secondary" type="button" data-clear-leads>Очистить</button>
        </div>
        <table class="pricing-table">
          <thead><tr><th>Дата</th><th>Тип</th><th>Контакт и запрос</th><th>Страница</th></tr></thead>
          <tbody>
            ${leads.map((lead) => `
              <tr>
                <td>${new Date(lead.createdAt).toLocaleString("ru-RU")}</td>
                <td>${lead.type}</td>
                <td>${fieldSummary(lead)}</td>
                <td>${lead.page}</td>
              </tr>
            `).join("")}
          </tbody>
        </table>
      `
      : `
        <div class="empty-state is-visible">
          <h2>Заявок пока нет</h2>
          <p class="small">Отправьте VIN, заявку на услугу или квиз на сайте, и запись появится здесь. Это локальный прототип будущей БД и Filament-админки.</p>
        </div>
      `;

    qs("[data-clear-leads]", root)?.addEventListener("click", () => {
      localStorage.removeItem(LEADS_KEY);
      render();
    });
  }

  render();
}

function initGallery() {
  const main = qs("[data-gallery-main]");
  const thumbs = qsa("[data-gallery-thumb]");
  if (!main || thumbs.length === 0) return;
  let index = 0;

  function show(next) {
    index = (next + thumbs.length) % thumbs.length;
    const thumb = thumbs[index];
    main.src = thumb.dataset.large;
    main.alt = thumb.dataset.alt;
    thumbs.forEach((item, itemIndex) => item.classList.toggle("is-active", itemIndex === index));
  }

  thumbs.forEach((thumb, thumbIndex) => {
    thumb.addEventListener("click", () => show(thumbIndex));
  });
  qs("[data-gallery-prev]")?.addEventListener("click", () => show(index - 1));
  qs("[data-gallery-next]")?.addEventListener("click", () => show(index + 1));
  show(0);
}

function initTradeIn() {
  const form = qs("[data-tradein-form]");
  if (!form) return;
  const result = qs("[data-tradein-result]");
  form.addEventListener("submit", (event) => {
    event.preventDefault();
    const newPrice = Number(form.dataset.price || 0);
    const value = Number(qs("[name='tradeinValue']", form).value || 0);
    const delta = Math.max(newPrice - value, 0);
    result.textContent = `Ориентировочная доплата: ${delta.toLocaleString("ru-RU")} ₽. Финальная оценка после осмотра дисков.`;
    reachGoal("tradein_calculate");
  });
}

function initRecentlyViewed() {
  const product = qs("[data-product-view]");
  const list = qs("[data-recently-viewed]");
  const key = "diskodiler-recent";

  if (product) {
    const current = {
      title: product.dataset.title,
      price: product.dataset.price,
      url: window.location.pathname
    };
    const saved = JSON.parse(localStorage.getItem(key) || "[]").filter((item) => item.title !== current.title);
    localStorage.setItem(key, JSON.stringify([current, ...saved].slice(0, 4)));
  }

  if (!list) return;
  const items = JSON.parse(localStorage.getItem(key) || "[]");
  list.innerHTML = items.length
    ? items.map((item) => `<a class="model-tile" href="${item.url}"><strong>${item.title}</strong><span class="small">${item.price}</span></a>`).join("")
    : `<p class="small">После просмотра товара здесь появятся последние комплекты.</p>`;
}

function initExitPopup() {
  const popup = qs("[data-exit-popup]");
  if (!popup || sessionStorage.getItem("diskodiler-exit-seen")) return;
  let armed = true;
  document.addEventListener("mouseleave", (event) => {
    if (!armed || event.clientY > 0) return;
    popup.classList.add("is-open");
    sessionStorage.setItem("diskodiler-exit-seen", "1");
    armed = false;
    reachGoal("exit_popup_show");
  });
  qsa("[data-close-exit]").forEach((button) => {
    button.addEventListener("click", () => popup.classList.remove("is-open"));
  });
}

function initChatBubbleMotion() {
  const bubble = qs(".chat-bubble");
  if (!bubble || window.matchMedia("(prefers-reduced-motion: reduce)").matches) return;

  let lastY = window.scrollY;
  let lastTime = performance.now();
  let resetTimer = null;
  let frame = null;

  function setLift(value) {
    bubble.style.setProperty("--chat-lift", `${value.toFixed(1)}px`);
  }

  window.addEventListener("scroll", () => {
    const now = performance.now();
    const currentY = window.scrollY;
    const scrollDelta = currentY - lastY;
    const deltaY = Math.abs(scrollDelta);
    const deltaTime = Math.max(now - lastTime, 16);
    const velocity = deltaY / deltaTime;
    const lift = scrollDelta >= 0
      ? Math.min(64, velocity * 62)
      : -Math.min(14, velocity * 24);

    lastY = currentY;
    lastTime = now;

    if (frame) cancelAnimationFrame(frame);
    frame = requestAnimationFrame(() => setLift(lift));

    clearTimeout(resetTimer);
    resetTimer = setTimeout(() => setLift(0), 180);
  }, { passive: true });
}

document.addEventListener("DOMContentLoaded", () => {
  renderSharedLayout();
  initTheme();
  initMenu();
  initGoals();
  initModals();
  initForms();
  initWheelQuiz();
  initGallery();
  initTradeIn();
  initRecentlyViewed();
  initLeadsAdmin();
  initExitPopup();
  initChatBubbleMotion();
});
