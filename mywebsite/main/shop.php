<?php
// Shop page - JavaScript driven products
?>

<!-- Shop For Supplies Heading -->
<div class="shop-heading">
    <h1 class="shop-title">Shop For Supplies</h1>
    <p class="shop-subtitle-display-intro">
        If the supplies you need are not available at the moment, please message us via
        <span><a class="shop-contact-link" href="https://web.facebook.com/p/Optimum-Payment-Solutions-100082955451105/?_rdc=1&_rdr#">Facebook</a></span>
        page or check back in 2 working days.
    </p>
</div>

<div class="control-bar-container">
    <form method="GET" action="shop.php" onsubmit="return false;">
        <!-- Search bar -->
        <div class="search-bar">
            <input type="text" id="shopSearchInput" name="search" placeholder="Search for supplies..." value="" autocomplete="off">
            <button type="button" class="search-btn btn-store" onclick="filterProducts()">Search</button>
        </div>

        <!-- Hidden input for sort -->
        <input type="hidden" name="sort" id="sortInput" value="name_asc">
        <input type="hidden" name="status_filter" id="statusInput" value="all">


        <!-- Control bar -->
        <div class="control-bar">
            <div class="control-left">
               
                <div class="refine-box" id="refineBox">
                    <button type="button" id="refineBtn" class="refine-btn btn-store">Refine By</button>
                    <ul class="refine-dropdown" id="refineDropdown">
                        <li><option value="all">All</option></li>
                        <li><option value="In Stock">In Stock</option></li>
                        <li><option value="Low Stock">Low Stock</option></li>
                        <li><option value="Available">Available</option></li>
                        <li><option value="Available in November">Available in November</option></li>
                        <!-- Add more statuses if needed -->
                    </ul>
                </div>

                <div class="sort-box" id="sortBox">
                    <span class="sort-text">Sort</span>
                    <span class="sort-arrow">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </span>
                    <ul class="sort-dropdown" id="sortDropdown">
                        <li><option value="name_asc">A-Z</option></li>
                        <li><option value="name_desc">Z-A</option></li>
                        <li><option value="newest">Newest</option></li>
                        <li><option value="oldest">Oldest</option></li>
                    </ul>
                </div>
            </div>

            <div class="control-right">
                <div><img id="grid2x3" src="<?= $base_url ?>/assets/svgs/1-col-grid.svg" alt=""></div>
                <div><img id="grid4x4" src="<?= $base_url ?>/assets/svgs/2-col-grid.svg" alt=""></div>
            </div>
        </div>
    </form>
</div>

<!-- Product Section with Aside Banner -->
<div class="product-section product-container">
    <div class="advertBanner-aside"></div>

    <!-- Products Container - JavaScript Rendered -->
    <div class="products-container products" id="productsGrid">
        <!-- Products will be rendered here by JavaScript -->
    </div>
</div>

<!-- Include shared products data -->
<script src="<?= $base_url ?>/assets/js/shop-products-data.js"></script>

<script>
// Current filtered/sorted products
let currentProducts = [...shopProducts];

// Render products to the grid
function renderProducts(products) {
    const grid = document.getElementById('productsGrid');
    
    if (products.length === 0) {
        grid.innerHTML = '<p class="no-products-message">No products found.</p>';
        return;
    }
    
    grid.innerHTML = products.map(product => `
        <div class="single-product-container">
            <a href="shop-product?id=${product.id}" class="product-link">
                <span class="badge-Available">${product.status}</span>
                <img class="single-product-image" src="${product.image}" alt="${product.name}">
                <div class="single-product-data">
                    <p class="single-product-title">${product.name}</p>
                </div>
            </a>
            <button class="cta-shop buy-now" onclick="event.stopPropagation(); window.open('${product.link}', '_blank')">
                Buy Now
            </button>
        </div>
    `).join('');
}

// Filter products by search term
function filterProducts() {
    const searchTerm = document.getElementById('shopSearchInput').value.toLowerCase().trim();
    const statusFilter = document.getElementById('statusInput').value;
    
    currentProducts = shopProducts.filter(product => {
        const matchesSearch = product.name.toLowerCase().includes(searchTerm);
        const matchesStatus = statusFilter === 'all' || product.status === statusFilter;
        return matchesSearch && matchesStatus;
    });
    
    sortProducts();
}

// Sort products
function sortProducts() {
    const sortValue = document.getElementById('sortInput').value;
    
    switch (sortValue) {
        case 'name_desc':
            currentProducts.sort((a, b) => b.name.localeCompare(a.name));
            break;
        case 'name_asc':
        default:
            currentProducts.sort((a, b) => a.name.localeCompare(b.name));
            break;
    }
    
    renderProducts(currentProducts);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    renderProducts(shopProducts);
});

// ========================================
// UI CONTROLS
// ========================================
const sortBox = document.getElementById("sortBox");
const sortDropdown = document.getElementById("sortDropdown");
const sortInput = document.getElementById("sortInput");
const shopSearchInput = document.getElementById("shopSearchInput");
const productsGrid = document.getElementById("productsGrid");

const refineBtn = document.getElementById("refineBtn");
const refineDropdown = document.getElementById("refineDropdown");
const statusInput = document.getElementById("statusInput");


// Toggle sort dropdown
sortBox.addEventListener("click", (e) => {
    e.stopPropagation();
    // Close refine dropdown if open
    refineDropdown.style.display = "none";
    // Toggle sort dropdown
    sortDropdown.style.display = sortDropdown.style.display === "block" ? "none" : "block";
});

// Toggle refine dropdown
refineBtn.addEventListener("click", (e) => {
    e.stopPropagation();
    // Close sort dropdown if open
    sortDropdown.style.display = "none";
    // Toggle refine dropdown
    refineDropdown.style.display = refineDropdown.style.display === "block" ? "none" : "block";
});

// Global click to close any open dropdown
document.addEventListener("click", () => {
    sortDropdown.style.display = "none";
    refineDropdown.style.display = "none";
});


// Click on dropdown items
document.querySelectorAll("#sortDropdown li").forEach(li => {
    li.addEventListener("click", () => {
        const value = li.querySelector("option").value;
        sortInput.value = value;
        filterProducts();
    });
});

document.querySelectorAll("#refineDropdown li").forEach(li => {
    li.addEventListener("click", () => {
        const value = li.querySelector("option").value;
        statusInput.value = value;
        filterProducts();
    });
});


// Live search as you type (AJAX-style instant filtering)
let searchTimeout;
shopSearchInput.addEventListener("input", (e) => {
    clearTimeout(searchTimeout);
    // Debounce: wait 300ms after user stops typing
    searchTimeout = setTimeout(() => {
        filterProducts();
    }, 300);
});

// Press Enter in search input
shopSearchInput.addEventListener("keypress", (e) => {
    if (e.key === 'Enter') {
        e.preventDefault();
        clearTimeout(searchTimeout);
        filterProducts();
    }
});

// Grid toggle
const grid2x3 = document.getElementById("grid2x3");
const grid4x4 = document.getElementById("grid4x4");

grid2x3.addEventListener("click", () => {
    productsGrid.style.gridTemplateColumns = "repeat(2, 1fr)";
});
grid4x4.addEventListener("click", () => {
    productsGrid.style.gridTemplateColumns = "repeat(4, 1fr)";
});
</script>

<link rel="stylesheet" href="<?= $base_url ?>/assets/css/shop.css">

<style>
    .refine-dropdown{
    position: absolute;
    /* top: 100%; */
    /* left: 0; */
    background: #ffffff;
    border: 1px solid #DDDDDD;
    list-style: none;
    padding: 0;
    margin: 5px 0 0 0;
    display: none;
    width: max-content;
    min-width: 120px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    z-index: 10;
}

.refine-dropdown li {
    padding: 8px 12px;
    cursor: pointer;
    font-size: 0.875rem;
}

.refine-dropdown li:hover {
    background-color: #f0f0f0;
}

a.shop-contact-link{
    color: var(--color-primary);
    text-decoration: underline;

}

/* Product Link Styles */
.product-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.single-product-container {
    display: flex;
    flex-direction: column;
}

.single-product-container .cta-shop {
    margin-top: auto;
}
    

</style>
<script>
// ========================================
// DYNAMIC ADVERT BANNER ROTATION (2-Day Interval)
// ========================================
(function() {
    // Configuration
    const useArray = false; // Set to true to enable image rotation
    const defaultImage = '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp';
    
    // Array of banner images (currently 7 duplicates - replace 6 later)
    const bannerImages = [
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp',
        '<?= $base_url ?>/assets/images/products/storeProducts/shopBanner-Revamp.webp'
    ];

    const advertBanner = document.querySelector('.advertBanner-aside');
    if (!advertBanner) return;

    // If useArray is false, use default image and exit
    if (!useArray) {
        advertBanner.style.background = `url(${defaultImage}) center/cover no-repeat`;
        return;
    }

    // Get stored data from localStorage
    const storageKey = 'shopBannerImage';
    const stored = localStorage.getItem(storageKey);
    let currentImage = null;
    let lastChanged = null;

    if (stored) {
        try {
            const data = JSON.parse(stored);
            currentImage = data.image;
            lastChanged = new Date(data.timestamp);
        } catch (e) {
            console.error('Error parsing stored banner data:', e);
        }
    }

    // Check if 2 days have passed
    const now = new Date();
    const twoDaysInMs = 2 * 24 * 60 * 60 * 1000; // 2 days in milliseconds
    const shouldChange = !lastChanged || (now - lastChanged >= twoDaysInMs);

    // Select new image if needed
    if (shouldChange || !currentImage) {
        // Randomly select an image from the array
        const randomIndex = Math.floor(Math.random() * bannerImages.length);
        currentImage = bannerImages[randomIndex];

        // Store the new selection
        localStorage.setItem(storageKey, JSON.stringify({
            image: currentImage,
            timestamp: now.toISOString()
        }));
    }

    // Apply the background image
    advertBanner.style.background = `url(${currentImage}) center/cover no-repeat`;
})();
</script>