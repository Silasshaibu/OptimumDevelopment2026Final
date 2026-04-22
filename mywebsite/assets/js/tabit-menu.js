/* ===========================
   PRODUCT DATA (1–12)
=========================== */
const tabitProducts = [
  {
    id: "tabit-pad",
    name: "Tabit PAD",
    slug: "Point of sale tablet",
    iconImg: "./assets/svgs/Tabit_PAD.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_PAD.webp",
    desc: "Tablet-based POS designed for fast service."
  },
  {
    id: "tabit-chef",
    name: "Tabit Chef",
    slug: "Kitchen display",
    iconImg: "./assets/svgs/Tabit_Chef.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Chef.webp",
    desc: "Real-time kitchen order management."
  },
  {
    id: "tabit-guest",
    name: "Tabit Guest",
    slug: "Guest experience",
    iconImg: "./assets/svgs/Tabit_Guest.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Guest.webp",
    desc: "Digital menus, payments, and loyalty."
  },
  {
    id: "tabit-analytics",
    name: "Tabit Analytics",
    slug: "Business insights",
    iconImg: "./assets/svgs/Tabit_Analytics.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Analytics.webp",
    desc: "Advanced analytics and reporting tools."
  },
  {
    id: "tabit-shift",
    name: "Tabit Shift",
    slug: "Staff scheduling",
    iconImg: "./assets/svgs/Tabit_Shift.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Shift.webp",
    desc: "Employee time and shift management."
  },
  {
    id: "tabit-hotels",
    name: "Tabit Hotels",
    slug: "Hotel integrations",
    iconImg: "./assets/svgs/Tabit_Hotels.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Hotels.webp",
    desc: "Contactless hotel dining experiences."
  },
  {
    id: "tabit-order",
    name: "Tabit Order",
    slug: "Digital ordering",
    iconImg: "./assets/svgs/Tabit_Order.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Order.webp",
    desc: "Flexible ordering across all channels."
  },
  {
    id: "tabit-wheels",
    name: "Tabit Wheels",
    slug: "Delivery management",
    iconImg: "./assets/svgs/Tabit_Wheels.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Wheels.webp",
    desc: "In-house delivery operations."
  },
  {
    id: "tabit-kiosk",
    name: "Tabit Kiosk",
    slug: "Self-service kiosks",
    iconImg: "./assets/svgs/Tabit_Kiosk.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Kiosk.webp",
    desc: "Reduce lines with self-order kiosks."
  },
  {
    id: "tabit-gift-cards",
    name: "Tabit Gift Cards",
    slug: "Gift card sales",
    iconImg: "./assets/svgs/Tabit_Gift_Cards.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Gift_Cards.webp",
    desc: "Sell digital & physical gift cards."
  },
  {
    id: "tabit-kitchen",
    name: "Tabit Kitchen",
    slug: "Kitchen ops",
    iconImg: "./assets/svgs/Tabit_Kitchen.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Kitchen.webp",
    desc: "Optimize prep and kitchen workflows."
  },
  {
    id: "tabit-feedback",
    name: "Tabit Feedback",
    slug: "Customer insights",
    iconImg: "./assets/svgs/Tabit_Feedback.svg",
    sectionImg: "./assets/images/TabitProducts/Tabit_Feedback.webp",
    desc: "Collect real-time guest feedback."
  }
];

/* ===========================
   RENDER MENU + SECTIONS
=========================== */
const tabitMenuGrid = document.querySelector(".tabit-mega-menu__grid");
const tabitSections = document.querySelector(".tabit-sections");

tabitProducts.forEach(p => {
  tabitMenuGrid.insertAdjacentHTML("beforeend", `
    <a href="#${p.id}" class="tabit-mega-menu__item">
      <div class="tabit-mega-menu__icon">
        <img src="${p.iconImg}" alt="${p.name} icon" loading="lazy">
      </div>

      <div>
        <div class="tabit-mega-menu__label">${p.name}</div>
        <div class="tabit-mega-menu__slug">${p.slug}</div>
      </div>
    </a>
  `);

  tabitSections.insertAdjacentHTML("beforeend", `
    <div id="${p.id}" class="tabit-section">
      <div class="tabit-card-image">
        <img 
          src="${p.sectionImg}" 
          alt="${p.name}"
          loading="lazy"
        >
      </div>
      <h2>${p.name}</h2>
      <p>${p.desc}</p>
    </div>
  `);
});

/* ===========================
   MEGA MENU TOGGLE
=========================== */
const tabitToggle = document.getElementById("tabitMegaMenuToggle");
const tabitMenu = document.getElementById("tabitMegaMenu");
const tabitCloseBtn = tabitMenu.querySelector(".tabit-mega-menu__close");

tabitToggle.addEventListener("click", () => {
  const open = tabitMenu.classList.toggle("open");
  tabitToggle.setAttribute("aria-expanded", open);
});

tabitCloseBtn.addEventListener("click", () => {
  tabitMenu.classList.remove("open");
  tabitToggle.setAttribute("aria-expanded", "false");
});

/* ===========================
   SCROLL + PULSE
=========================== */
document.addEventListener("click", e => {
  const tabitLink = e.target.closest(".tabit-mega-menu__item");
  if (!tabitLink) return;

  const tabitTarget = document.querySelector(tabitLink.getAttribute("href"));
  if (!tabitTarget) return;

  document.querySelectorAll(".tabit-section").forEach(section =>
    section.classList.remove("pulse")
  );

  setTimeout(() => tabitTarget.classList.add("pulse"), 600);
});
