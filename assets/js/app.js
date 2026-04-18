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

const sharedNavItems = [
  { page: "catalog", label: "Каталог", href: "catalog.html" },
  { page: "product", label: "Пример товара", href: "product.html" },
  { page: "services", label: "Услуги", href: "services.html" },
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
    vinGoal: "vin_modal_submit"
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
  }
};

function actionAttributes(action) {
  const goal = action.goal ? ` data-goal="${action.goal}"` : "";
  if (action.href) return `href="${action.href}"${goal}`;
  return `type="button" data-open-modal="${action.modal}"${goal}`;
}

function actionTag(action, className = "btn") {
  const tag = action.href ? "a" : "button";
  return `<${tag} class="${className}" ${actionAttributes(action)}>${action.label}</${tag}>`;
}

function renderHeader(page, config) {
  const desktopNav = sharedNavItems.map((item) => {
    const current = item.page === page ? ' aria-current="page"' : "";
    return `<a href="${item.href}"${current}>${item.label}</a>`;
  }).join("");
  const mobileNav = [
    { page: "home", label: "Главная", href: "index.html" },
    ...sharedNavItems,
    { label: "Позвонить", href: "tel:+79669264666" }
  ].filter((item) => item.page !== page).map((item) => `<a href="${item.href}">${item.label}</a>`).join("");

  return `
    <header class="site-header">
      <div class="topline">
        <div class="container topline-inner">
          <span>${config.topline}</span>
          <a href="tel:+79669264666">+7 (966) 926-46-66</a>
        </div>
      </div>
      <div class="container header-inner">
        <a class="logo" href="index.html" aria-label="ДискоДилер на главную">
          <img src="assets/img/logo.webp" alt="ДискоДилер" width="88" height="88">
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
          <img class="footer-logo" src="assets/img/logo.webp" alt="ДискоДилер" width="231" height="70" loading="lazy">
          <p class="small">${config.footerText}</p>
        </div>
        <div class="footer-links">
          <a href="tel:+79669264666">+7 (966) 926-46-66</a>
          <a href="${WHATSAPP_URL}" data-goal="footer_whatsapp">WhatsApp</a>
          <a href="mailto:shop@diskodiler.ru">shop@diskodiler.ru</a>
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
      <a href="${WHATSAPP_URL}" aria-label="Написать в WhatsApp" data-goal="chat_whatsapp"><img src="assets/img/messengers/icon-whatsapp.png" alt="" loading="lazy"></a>
      <button type="button" aria-label="Telegram пока не указан" data-open-modal="contact-modal" data-goal="chat_telegram_fallback"><img src="assets/img/messengers/icon-telegram.png" alt="" loading="lazy"></button>
      <button type="button" aria-label="Max пока не указан" data-open-modal="contact-modal" data-goal="chat_max_fallback"><img src="assets/img/messengers/icon-max.png" alt="" loading="lazy"></button>
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
          <div><h2 id="service-modal-title">Запись на сервис</h2><p class="small">Укажите модель, диаметр и желаемую услугу.</p></div>
          <button class="icon-btn" type="button" data-close-modal aria-label="Закрыть">×</button>
        </div>
        <form data-lead-form data-goal="${config.serviceGoal}">
          <input class="input" name="phone" placeholder="+7 (___) ___-__-__" autocomplete="tel">
          <textarea class="textarea" name="message" placeholder="Например: BMW X5 G05, R21, RunFlat"></textarea>
          <button class="btn" type="submit">Отправить</button>
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
      reachGoal(form.dataset.goal || "vin_submit");
      if (notice) {
        notice.textContent = "VIN принят. Менеджер проверит комплектацию, OEM-артикулы и совместимость по вылету/PCD.";
        notice.classList.add("is-visible");
      }
    });
  });

  qsa("[data-lead-form]").forEach((form) => {
    form.addEventListener("submit", (event) => {
      event.preventDefault();
      reachGoal(form.dataset.goal || "lead_submit");
      const notice = qs(".notice", form.parentElement);
      if (notice) {
        notice.textContent = "Заявка сохранена. Для демонстрации сайта отправка подключается к CRM на этапе интеграции.";
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
  Lamborghini: ["Urus", "Huracan", "Aventador"]
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

    function syncContactRequirement() {
      const telegram = qs("[name='telegram']", form);
      const method = selectedRadio("contactMethod")?.value;
      if (!telegram) return;
      telegram.required = method === "Telegram";
      if (method !== "Telegram") telegram.removeAttribute("aria-invalid");
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
        syncContactRequirement();
        const method = selectedRadio("contactMethod")?.value;
        const telegram = qs("[name='telegram']", step);
        const phone = qs("[name='phone']", step);
        const consent = qs("[name='consent']", step);
        valid = Boolean(phone?.value.trim()) && Boolean(consent?.checked);
        if (method === "Telegram") valid = valid && Boolean(telegram?.value.trim());
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
        syncContactRequirement();
        updateControls();
      });
      field.addEventListener("change", () => {
        syncContactRequirement();
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

const catalogItems = [
  {
    brand: "BMW",
    model: "X5 G05",
    year: "2024",
    size: "R20",
    style: "Double Spoke",
    color: "Jet Black",
    title: '20" Double Spoke 699 Jet Black',
    oem: "36118089896",
    price: "190 000 ₽",
    fit: "BMW X5 G05",
    stock: "Осталось 2 шт.",
    specs: "5x112 • ET35 • DIA 66.6",
    image: "https://images.unsplash.com/photo-1603386329225-868f9b1ee6c9?auto=format&fit=crop&w=900&q=80"
  },
  {
    brand: "BMW",
    model: "X3 G01",
    year: "2023",
    size: "R19",
    style: "Y-Spoke",
    color: "Ferricgrey",
    title: '19" Y-Spoke 898M Performance',
    oem: "36118091508",
    price: "269 000 ₽",
    fit: "BMW X3 G01",
    stock: "Осталось 4 шт.",
    specs: "5x112 • ET32 • DIA 66.6",
    image: "https://images.unsplash.com/photo-1555215695-3004980ad54e?auto=format&fit=crop&w=900&q=80"
  },
  {
    brand: "BMW",
    model: "3/4 G20",
    year: "2022",
    size: "R19",
    style: "Double Spoke",
    color: "Night Gold",
    title: '19" Style 793 Individual',
    oem: "36118089896 / 36118089897",
    price: "259 000 ₽",
    fit: "BMW 3 / 4 G20 G22 G23",
    stock: "Осталось 2 шт.",
    specs: "5x112 • ET27/40 • DIA 66.6",
    image: "https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=900&q=80"
  },
  {
    brand: "Mercedes-Benz",
    model: "GLE W167",
    year: "2024",
    size: "R21",
    style: "V-Spoke",
    color: "Bicolor",
    title: '21" AMG V-Spoke Bicolor',
    oem: "A1674012700",
    price: "Цена по запросу",
    fit: "Mercedes-Benz GLE W167",
    stock: "Осталось 1 комплект",
    specs: "5x112 • ET49 • DIA 66.6",
    image: "https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=900&q=80"
  },
  {
    brand: "Porsche",
    model: "Cayenne",
    year: "2023",
    size: "R22",
    style: "Y-Spoke",
    color: "Jet Black",
    title: '22" Cayenne RS Spyder Design',
    oem: "9Y0601025",
    price: "330 000 ₽",
    fit: "Porsche Cayenne",
    stock: "Осталось 2 шт.",
    specs: "5x130 • ET50 • DIA 71.6",
    image: "https://images.unsplash.com/photo-1503736334956-4c8f8e92946d?auto=format&fit=crop&w=900&q=80"
  },
  {
    brand: "Range Rover",
    model: "Sport",
    year: "2024",
    size: "R23",
    style: "Double Spoke",
    color: "Bicolor",
    title: '23" Range Rover Style 1075',
    oem: "LR161547",
    price: "310 000 ₽",
    fit: "Range Rover Sport",
    stock: "Осталось 2 шт.",
    specs: "5x120 • ET47 • DIA 72.6",
    image: "https://images.unsplash.com/photo-1492144534655-ae79c964c9d7?auto=format&fit=crop&w=900&q=80"
  }
];

function initCatalog() {
  const grid = qs("[data-products-grid]");
  const form = qs("[data-filter-form]");
  if (!grid || !form) return;

  const params = new URLSearchParams(window.location.search);
  qsa("select", form).forEach((select) => {
    if (params.get(select.name)) select.value = params.get(select.name);
  });

  function matches(item, data) {
    return Object.entries(data).every(([key, value]) => !value || item[key] === value);
  }

  function card(item) {
    return `
      <article class="product-card" data-product-card>
        <div class="product-media">
          <img src="${item.image}" alt="${item.title}" width="900" height="900" loading="lazy" decoding="async">
        </div>
        <div class="product-body">
          <div class="product-title">
            <span class="badge accent">${item.fit}</span>
            <h3>${item.title}</h3>
            <p class="small">OEM: ${item.oem}</p>
          </div>
          <p class="spec-list">${item.specs}<br>${item.brand} • ${item.model} • ${item.year}</p>
          <div class="hero-meta">
            <span class="badge">${item.color}</span>
            <span class="badge">${item.stock}</span>
          </div>
          <p class="price">${item.price}</p>
          <div class="card-actions">
            <a class="btn" href="product.html" data-goal="catalog_product_details">Подробнее</a>
          </div>
        </div>
      </article>
    `;
  }

  function render() {
    const data = Object.fromEntries(new FormData(form).entries());
    const filtered = catalogItems.filter((item) => matches(item, data));
    grid.innerHTML = filtered.map(card).join("");
    qs("[data-result-count]").textContent = `${filtered.length} комплектов`;
    qs("[data-empty-state]")?.classList.toggle("is-visible", filtered.length === 0);
    const url = new URL(window.location);
    Object.entries(data).forEach(([key, value]) => {
      if (value) url.searchParams.set(key, value);
      else url.searchParams.delete(key);
    });
    history.replaceState(null, "", url);
    initModals();
    initGoals();
  }

  form.addEventListener("change", () => {
    reachGoal("catalog_filter_apply");
    render();
  });
  form.addEventListener("reset", () => {
    setTimeout(render, 0);
  });
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
  initCatalog();
  initGallery();
  initTradeIn();
  initRecentlyViewed();
  initExitPopup();
  initChatBubbleMotion();
});
