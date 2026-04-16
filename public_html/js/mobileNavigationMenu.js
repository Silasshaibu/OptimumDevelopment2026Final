const processingSubItems = [
    "Full Service Fine Dining",
    "QSR and Food Trucks",
    "Bars / Night Clubs / High Volume",
    "Retail / Liquor / Smoke Shops",
    "QSR and Food Trucks",
    "Bars / Night Clubs / High Volume",
    "Retail / Liquor / Smoke Shops",
];

// Build processing submenu HTML
const subProcessing = document.getElementById('sub-processing');
processingSubItems.forEach((label, i) => {
    const wrapper = document.createElement('div');
    wrapper.innerHTML = `
      <div class="proc-item-header" data-proc-index="${i}">
        <p>${label}</p>
        <button class="proc-toggle-btn" aria-label="Toggle ${label}">
          <svg fill="none" viewBox="0 0 12 12">
            <path class="plus-h" d="M9.75 6H2.25" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
            <path class="plus-v" d="M6 2.25V9.75" stroke="black" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"/>
          </svg>
        </button>
      </div>
      ${i === 0 ? `
      <div class="proc-products" id="proc-products-0">
        <div class="proc-products-inner">
          <div class="proc-product">
            <div class="proc-product-img">
              <img src="src/imports/MobileNavigationProcessingSolutionsDropDownOpenNestedChild/7c9293d69701c3f00a1d66d4123af12448235a3d.png" alt="Union POS"/>
            </div>
            <p class="proc-product-name">Union POS</p>
            <p class="proc-product-desc">Manage order, sales, and payments in one place</p>
          </div>
          <div class="proc-product">
            <div class="proc-product-img">
              <img src="src/imports/MobileNavigationProcessingSolutionsDropDownOpenNestedChild/69a4ecc1519c8a77c7b258f7faaf753e1b936e60.png" alt="Clover"/>
            </div>
            <p class="proc-product-name">Clover</p>
            <p class="proc-product-desc">Do what you do better with the world's smartest POS system</p>
          </div>
        </div>
      </div>` : ''}
    `;
    subProcessing.appendChild(wrapper);
});

// State
let menuOpen = false;
let expandedMenu = null;
let expandedProcItem = 0; // index, -1 = none

const hamburgerBtn = document.getElementById('hamburger-btn');
const iconHamburger = document.getElementById('icon-hamburger');
const iconClose = document.getElementById('icon-close');
const menuPanel = document.getElementById('menu-panel');
const menuRows = document.querySelectorAll('.menu-row');
const submenus = document.querySelectorAll('.submenu');

function closeAllSubmenus() {
    submenus.forEach(s => s.classList.remove('open'));
    menuRows.forEach(r => {
        r.classList.remove('active');
        const chevron = r.querySelector('.chevron');
        if (chevron) {
            chevron.classList.remove('flipped');
            chevron.querySelector('path').setAttribute('stroke', '#0E0E0E');
        }
    });
    expandedMenu = null;
}

function openSubmenu(id) {
    const sub = document.getElementById('sub-' + id);
    const row = document.querySelector(`.menu-row[data-id="${id}"]`);
    if (!sub || !row) return;
    sub.classList.add('open');
    row.classList.add('active');
    const chevron = row.querySelector('.chevron');
    if (chevron) {
        chevron.classList.add('flipped');
        chevron.querySelector('path').setAttribute('stroke', 'white');
    }
    expandedMenu = id;
}

hamburgerBtn.addEventListener('click', () => {
    menuOpen = !menuOpen;
    if (menuOpen) {
        iconHamburger.style.display = 'none';
        iconClose.style.display = 'block';
        menuPanel.classList.add('open');
        // default: open processing submenu with first sub-item
        openSubmenu('processing');
        setProcItem(0);
    } else {
        iconHamburger.style.display = 'block';
        iconClose.style.display = 'none';
        menuPanel.classList.remove('open');
        closeAllSubmenus();
    }
});

menuRows.forEach(row => {
    const btn = row.querySelector('button');
    const id = row.dataset.id;
    const hasSub = ['processing', 'digital', 'financing', 'about'].includes(id);
    if (!hasSub) return;
    btn.addEventListener('click', () => {
        if (expandedMenu === id) {
            closeAllSubmenus();
        } else {
            closeAllSubmenus();
            openSubmenu(id);
            if (id === 'processing') setProcItem(0);
        }
    });
});

// Processing sub-item accordion
function setProcItem(index) {
    expandedProcItem = index;
    const headers = subProcessing.querySelectorAll('.proc-item-header');
    const productsEl = document.getElementById('proc-products-0');
    headers.forEach((h, i) => {
        const plusV = h.querySelector('.plus-v');
        if (i === index) {
            if (plusV) plusV.style.display = 'none'; // show minus (collapse icon)
        } else {
            if (plusV) plusV.style.display = '';
        }
    });
    if (productsEl) {
        productsEl.classList.toggle('open', index === 0);
    }
}

subProcessing.addEventListener('click', (e) => {
    const btn = e.target.closest('.proc-toggle-btn');
    if (!btn) return;
    const header = btn.closest('.proc-item-header');
    const idx = parseInt(header.dataset.procIndex, 10);
    setProcItem(expandedProcItem === idx ? -1 : idx);
});