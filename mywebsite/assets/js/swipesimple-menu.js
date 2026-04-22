/* ===========================
   PRODUCT DATA – SWIPE SIMPLE
=========================== */
const swipeSimpleProducts = [
  {
    id: "swipesimple-payments",
    name: "SwipeSimple Payments",
    slug: "Accept payments anywhere",
    iconImg: "./assets/svgs/swipesimple_payments.svg",
    sectionImg: "./assets/images/SwipeSimple/SwipeSimple_Payments.webp",
    desc: "Accept payments on your phone, tablet, or computer."
  },
  {
    id: "swipesimple-terminal",
    name: "SwipeSimple Terminal",
    slug: "All-in-one device",
    iconImg: "./assets/svgs/swipesimple_terminal.svg",
    sectionImg: "./assets/images/SwipeSimple/SwipeSimple_Terminal.webp",
    desc: "The all-in-one credit card device that fits in your hand."
  },
  {
    id: "swipesimple-register",
    name: "SwipeSimple Register",
    slug: "POS system",
    iconImg: "./assets/svgs/swipesimple_register.svg",
    sectionImg: "./assets/images/SwipeSimple/SwipeSimple_Register.webp",
    desc: "The easy-to-use POS system packed with time-saving features."
  }
];


/* ===========================
   RENDER MENU + SECTIONS
=========================== */
const swipeMenuGrid = document.querySelector(".swipesimple-mega-menu__grid");
const swipeSections = document.querySelector(".swipesimple-sections");

swipeSimpleProducts.forEach(p => {
  swipeMenuGrid.insertAdjacentHTML("beforeend", `
    <a href="#${p.id}" class="swipesimple-mega-menu__item">
      <div class="swipesimple-mega-menu__icon">
        <img src="${p.iconImg}" alt="" loading="lazy">
      </div>
      <div>
        <div class="swipesimple-mega-menu__label">${p.name}</div>
        <div class="swipesimple-mega-menu__slug">${p.slug}</div>
      </div>
    </a>
  `);

  swipeSections.insertAdjacentHTML("beforeend", `
    <div id="${p.id}" class="swipesimple-section">
      <div class="swipesimple-card-image">
        <img src="${p.sectionImg}" alt="${p.name}" loading="lazy">
      </div>
      <h2>${p.name}</h2>
      <p>${p.desc}</p>
    </div>
  `);
});

/* ===========================
   TOGGLE MENU
=========================== */
const swipeToggle = document.getElementById("swipeSimpleMegaMenuToggle");
const swipeMenu = document.getElementById("swipeSimpleMegaMenu");
const swipeClose = swipeMenu.querySelector(".swipesimple-mega-menu__close");

swipeToggle.addEventListener("click", () => {
  const open = swipeMenu.classList.toggle("open");
  swipeToggle.setAttribute("aria-expanded", open);
});

swipeClose.addEventListener("click", () => {
  swipeMenu.classList.remove("open");
  swipeToggle.setAttribute("aria-expanded", "false");
});

/* ===========================
   SCROLL + PULSE
=========================== */
document.addEventListener("click", e => {
  const link = e.target.closest(".swipesimple-mega-menu__item");
  if (!link) return;

  const target = document.querySelector(link.getAttribute("href"));
  if (!target) return;

  document.querySelectorAll(".swipesimple-section")
    .forEach(s => s.classList.remove("pulse"));

  setTimeout(() => target.classList.add("pulse"), 600);
});
