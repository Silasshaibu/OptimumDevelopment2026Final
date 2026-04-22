const processingSubItems = [
    "Full Service Fine Dining",
    "QSR and Food Trucks",
    "Bars / Night Clubs / High Volume",
    "Retail / Liquor / Smoke Shops",
    "QSR and Food Trucks",
    "Bars / Night Clubs / High Volume",
    "Retail / Liquor / Smoke Shops",
];

function getProductsForCategory(index) {
    const categories = [
        // Full Service Fine Dining - at least 4
        [
            { img: "assets/hhd-products/hhd-clover-flex.png", name: "Clover Flex", desc: "Flexible POS for fine dining" },
            { img: "assets/hhd-products/hhd-valor-vp-550.png", name: "Valor VP550", desc: "Advanced payment processing" },
            { img: "assets/hhd-products/hhd-clover-go-plus.png", name: "Clover Go Plus", desc: "Portable POS solution" },
            { img: "assets/hhd-products/hhd-valor-vl-100.png", name: "Valor VL100", desc: "Reliable payment terminal" }
        ],
        // QSR and Food Trucks - at least 3
        [
            { img: "assets/hhd-products/hhd-valor-vp-800.png", name: "Valor VP800", desc: "High-volume processing" },
            { img: "assets/hhd-products/hhd-clover-flex.png", name: "Clover Flex", desc: "Quick service POS" },
            { img: "assets/hhd-products/hhd-valor-vl-110.png", name: "Valor VL110", desc: "Compact terminal" }
        ],
        // Bars / Night Clubs / High Volume - at least 3
        [
            { img: "assets/hhd-products/hhd-valor-vp-550.png", name: "Valor VP550", desc: "High-volume payments" },
            { img: "assets/hhd-products/hhd-clover-go-plus.png", name: "Clover Go Plus", desc: "Mobile payments" },
            { img: "assets/hhd-products/hhd-valor-vp-800.png", name: "Valor VP800", desc: "Robust processing" }
        ],
        // Retail / Liquor / Smoke Shops - at least 3
        [
            { img: "assets/hhd-products/hhd-valor-vl-100.png", name: "Valor VL100", desc: "Retail payments" },
            { img: "assets/hhd-products/hhd-clover-flex.png", name: "Clover Flex", desc: "Flexible retail POS" },
            { img: "assets/hhd-products/hhd-valor-vl-110.png", name: "Valor VL110", desc: "Countertop terminal" }
        ],
        // Repeat for the duplicates
        [
            { img: "assets/hhd-products/hhd-valor-vp-800.png", name: "Valor VP800", desc: "High-volume processing" },
            { img: "assets/hhd-products/hhd-clover-flex.png", name: "Clover Flex", desc: "Quick service POS" },
            { img: "assets/hhd-products/hhd-valor-vl-110.png", name: "Valor VL110", desc: "Compact terminal" }
        ],
        [
            { img: "assets/hhd-products/hhd-valor-vp-550.png", name: "Valor VP550", desc: "High-volume payments" },
            { img: "assets/hhd-products/hhd-clover-go-plus.png", name: "Clover Go Plus", desc: "Mobile payments" },
            { img: "assets/hhd-products/hhd-valor-vp-800.png", name: "Valor VP800", desc: "Robust processing" }
        ],
        [
            { img: "assets/hhd-products/hhd-valor-vl-100.png", name: "Valor VL100", desc: "Retail payments" },
            { img: "assets/hhd-products/hhd-clover-flex.png", name: "Clover Flex", desc: "Flexible retail POS" },
            { img: "assets/hhd-products/hhd-valor-vl-110.png", name: "Valor VL110", desc: "Countertop terminal" }
        ]
    ];
    return categories[index].map(product => `
        <a href="#" class="proc-product-link">
            <div class="proc-product">
                <div class="proc-product-img">
                    <img src="${product.img}" alt="${product.name}"/>
                </div>
                <p class="proc-product-name">${product.name}</p>
                <p class="proc-product-desc">${product.desc}</p>
            </div>
        </a>
    `).join('');
}

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
      <div class="proc-products" id="proc-products-${i}">
        <div class="proc-products-inner">
          ${getProductsForCategory(i)}
        </div>
      </div>
    `;
    subProcessing.appendChild(wrapper);
});

// State
let menuOpen = false;
let expandedMenu = null;
let expandedProcItem = -1; // index, -1 = none

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
        // default: open processing submenu
        openSubmenu('processing');
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
        }
    });
});

// Processing sub-item accordion
function setProcItem(index) {
    expandedProcItem = index;
    const headers = subProcessing.querySelectorAll('.proc-item-header');
    headers.forEach((h, i) => {
        const plusV = h.querySelector('.plus-v');
        const productsEl = document.getElementById(`proc-products-${i}`);
        if (i === index) {
            if (plusV) plusV.style.opacity = '0'; // hide vertical line to make minus
            if (productsEl) productsEl.classList.add('open');
        } else {
            if (plusV) plusV.style.opacity = '1';
            if (productsEl) productsEl.classList.remove('open');
        }
    });

    // Reset scroll positions when changing/closing nested items
    const cardWrapper = document.querySelector('.proc-products-inner');
    if (cardWrapper) {
        cardWrapper.scrollLeft = 0; // Reset horizontal slide position of card wrapper
    }

    // Reset vertical scroll position of any nested scrollable content
    const submenu = document.getElementById('sub-processing');
    if (submenu) {
        submenu.scrollTop = 0; // Reset vertical scroll of the submenu container
    }
}

subProcessing.addEventListener('click', (e) => {
    const header = e.target.closest('.proc-item-header');
    if (!header) return;
    const idx = parseInt(header.dataset.procIndex, 10);
    setProcItem(expandedProcItem === idx ? -1 : idx);
});