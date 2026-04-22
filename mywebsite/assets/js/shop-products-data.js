// ========================================
// SHOP PRODUCTS DATA (Shared across pages)
// ========================================
const shopProducts = [
    {
        id: "clover-flex-paper",
        name: "Clover Flex Paper",
        image: "./assets/images/products/storeProducts/CloverFlexPaper.webp",
        images: [
            "./assets/images/products/storeProducts/CloverFlexPaper.webp",
            "./assets/images/products/storeProducts/CloverFlexPaper.webp",
            { src: "./assets/videos/products/clover-flex-paper-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/CloverFlexPaper.webp"
        ],
        status: "In Stock",
        price: "$24.99",
        link: "https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20",
        description: "High-quality thermal paper rolls designed specifically for the Clover Flex mobile POS system. These 2 1/4\" x 50' rolls ensure crisp, clear receipts every time.",
        features: [
            "2 1/4\" x 50' thermal paper rolls",
            "Compatible with Clover Flex",
            "BPA-free thermal paper",
            "Crisp, clear printing",
            "Long-lasting receipts",
            "Pack of 50 rolls"
        ],
        category: "Paper Supplies"
    },
    {
        id: "clover-mini-paper",
        name: "Clover Mini Paper",
        image: "./assets/images/products/storeProducts/CloverMini_Paper_1-1.webp",
        images: [
            "./assets/images/products/storeProducts/CloverMini_Paper_1-1.webp",
            "./assets/images/products/storeProducts/CloverMini_Paper_1-1.webp",
            { src: "./assets/videos/products/clover-mini-paper-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/CloverMini_Paper_1-1.webp"
        ],
        status: "In Stock",
        price: "$22.99",
        link: "https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20",
        description: "Premium thermal paper rolls perfectly sized for the Clover Mini countertop POS terminal. Reliable performance for high-volume businesses.",
        features: [
            "2 1/4\" x 85' thermal paper rolls",
            "Compatible with Clover Mini",
            "BPA-free thermal paper",
            "Fade-resistant printing",
            "Smooth feed technology",
            "Pack of 50 rolls"
        ],
        category: "Paper Supplies"
    },
    {
        id: "clover-station-paper",
        name: "Clover Station Paper",
        image: "./assets/images/products/storeProducts/CloverStationPaper.webp",
        images: [
            "./assets/images/products/storeProducts/CloverStationPaper.webp",
            "./assets/images/products/storeProducts/CloverStationPaper.webp",
            { src: "./assets/videos/products/clover-station-paper-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/CloverStationPaper.webp"
        ],
        status: "In Stock",
        price: "$29.99",
        link: "https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20",
        description: "Professional-grade thermal paper rolls for Clover Station and Clover Station Duo. Wide format for detailed receipts with room for logos and promotions.",
        features: [
            "3 1/8\" x 230' thermal paper rolls",
            "Compatible with Clover Station & Duo",
            "BPA-free thermal paper",
            "Extra-long rolls reduce changes",
            "Professional receipt quality",
            "Pack of 50 rolls"
        ],
        category: "Paper Supplies"
    },
    {
        id: "clover-cash-drawer",
        name: "Clover Cash Drawer",
        image: "./assets/images/products/storeProducts/Clover_Cash_Drawer_1-1.webp",
        images: [
            "./assets/images/products/storeProducts/Clover_Cash_Drawer_1-1.webp",
            "./assets/images/products/storeProducts/Clover_Cash_Drawer_1-1.webp",
            { src: "./assets/videos/products/clover-cash-drawer-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/Clover_Cash_Drawer_1-1.webp"
        ],
        status: "In Stock",
        price: "$89.99",
        link: "https://www.amazon.com/dp/B01LZWOK0J?tag=optimumpay-20",
        description: "Heavy-duty cash drawer designed for seamless integration with Clover POS systems. Features durable steel construction and multiple bill/coin compartments.",
        features: [
            "5 bill / 8 coin compartments",
            "Heavy-duty steel construction",
            "RJ11/RJ12 printer connection",
            "Manual key lock override",
            "Under-counter mounting option",
            "Black finish"
        ],
        category: "Hardware"
    },
    {
        id: "2d-clover-barcode-scanner",
        name: "2D Clover Barcode Scanner",
        image: "./assets/images/products/storeProducts/2D_Clover_BarcodeScanner_1-1.webp",
        images: [
            "./assets/images/products/storeProducts/2D_Clover_BarcodeScanner_1-1.webp",
            "./assets/images/products/storeProducts/2D_Clover_BarcodeScanner_1-1.webp",
            { src: "./assets/videos/products/2d-clover-barcode-scanner-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/2D_Clover_BarcodeScanner_1-1.webp"
        ],
        status: "In Stock",
        price: "$149.99",
        link: "https://www.amazon.com/dp/B07D7411FQ?tag=optimumpay-20",
        description: "High-performance 2D barcode scanner compatible with all Clover POS systems. Reads 1D and 2D barcodes including QR codes for modern payment and inventory needs.",
        features: [
            "Reads 1D and 2D barcodes",
            "QR code compatible",
            "USB plug-and-play",
            "Hands-free stand included",
            "Fast scanning speed",
            "Works with all Clover systems"
        ],
        category: "Hardware"
    },
    {
        id: "dejavoo-z8",
        name: "Dejavoo Z8",
        image: "./assets/images/products/storeProducts/DejavooZ8.webp",
        images: [
            "./assets/images/products/storeProducts/DejavooZ8.webp",
            "./assets/images/products/storeProducts/DejavooZ8.webp",
            { src: "./assets/videos/products/dejavoo-z8-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/DejavooZ8.webp"
        ],
        status: "Available",
        price: "Contact Us",
        link: "#",
        description: "The Dejavoo Z8 is a compact, wireless payment terminal perfect for businesses on the go. Features EMV chip, NFC contactless, and magstripe payment acceptance.",
        features: [
            "Wireless connectivity (WiFi/4G)",
            "EMV chip card reader",
            "NFC contactless payments",
            "Compact portable design",
            "Long battery life",
            "Touch screen display"
        ],
        category: "Payment Terminals"
    },
    {
        id: "dejavoo-z9",
        name: "Dejavoo Z9",
        image: "./assets/images/products/storeProducts/DejavooZ9.webp",
        images: [
            "./assets/images/products/storeProducts/DejavooZ9.webp",
            "./assets/images/products/storeProducts/DejavooZ9.webp",
            { src: "./assets/videos/products/dejavoo-z9-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/DejavooZ9.webp"
        ],
        status: "Available",
        price: "Contact Us",
        link: "#",
        description: "The Dejavoo Z9 countertop terminal offers reliable payment processing with a larger screen and full keypad. Ideal for retail and restaurant environments.",
        features: [
            "Ethernet and dial-up connectivity",
            "EMV chip card reader",
            "NFC contactless payments",
            "Full numeric keypad",
            "Large backlit display",
            "Built-in thermal printer"
        ],
        category: "Payment Terminals"
    },
    {
        id: "dejavoo-z11",
        name: "Dejavoo Z11",
        image: "./assets/images/products/storeProducts/DejavooZ11.webp",
        images: [
            "./assets/images/products/storeProducts/DejavooZ11.webp",
            "./assets/images/products/storeProducts/DejavooZ11.webp",
            { src: "./assets/videos/products/dejavoo-z11-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/DejavooZ11.webp"
        ],
        status: "Available",
        price: "Contact Us",
        link: "#",
        description: "The Dejavoo Z11 features a large touchscreen display for an enhanced customer experience. Perfect for businesses wanting a modern, intuitive payment solution.",
        features: [
            "7-inch touchscreen display",
            "WiFi and Ethernet connectivity",
            "EMV chip card reader",
            "NFC contactless payments",
            "Signature capture",
            "Built-in high-speed printer"
        ],
        category: "Payment Terminals"
    },
    {
        id: "ink-ribbon-star-micronics",
        name: "Ink Ribbon Star Micronics",
        image: "./assets/images/products/storeProducts/InkRibbonStarMicronics.webp",
        images: [
            "./assets/images/products/storeProducts/InkRibbonStarMicronics.webp",
            "./assets/images/products/storeProducts/InkRibbonStarMicronics.webp",
            { src: "./assets/videos/products/ink-ribbon-star-micronics-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/InkRibbonStarMicronics.webp"
        ],
        status: "In Stock",
        price: "$12.99",
        link: "https://www.amazon.com/dp/B00006ISCX?tag=optimumpay-20",
        description: "Genuine Star Micronics ink ribbon for SP700 series impact printers. Long-lasting ribbon ensures thousands of clear, legible prints for kitchen orders.",
        features: [
            "Genuine Star Micronics ribbon",
            "Compatible with SP700 series",
            "Black/red dual-color option",
            "3 million character yield",
            "Easy snap-in installation",
            "Pack of 6 ribbons"
        ],
        category: "Printer Supplies"
    },
    {
        id: "star-micronics-paper",
        name: "Star Micronics Paper",
        image: "./assets/images/products/storeProducts/StarMicronicsPaper.webp",
        images: [
            "./assets/images/products/storeProducts/StarMicronicsPaper.webp",
            "./assets/images/products/storeProducts/StarMicronicsPaper.webp",
            { src: "./assets/videos/products/star-micronics-paper-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/StarMicronicsPaper.webp"
        ],
        status: "In Stock",
        price: "$34.99",
        link: "https://www.amazon.com/dp/B07YJNK8WP?tag=optimumpay-20",
        description: "Premium bond paper rolls for Star Micronics SP700 impact printers. Two-ply carbonless paper perfect for kitchen order systems requiring duplicate copies.",
        features: [
            "3\" x 90' two-ply rolls",
            "Carbonless duplicate copies",
            "Compatible with SP700 series",
            "White/canary yellow plies",
            "Smooth, jam-free feed",
            "Pack of 50 rolls"
        ],
        category: "Paper Supplies"
    },
    {
        id: "star-micronics-sp700",
        name: "Star Micronics SP700",
        image: "./assets/images/products/storeProducts/Star_Micronics_SP700_1-1.webp",
        images: [
            "./assets/images/products/storeProducts/Star_Micronics_SP700_1-1.webp",
            "./assets/images/products/storeProducts/Star_Micronics_SP700_1-1.webp",
            { src: "./assets/videos/products/star-micronics-sp700-demo.mp4", isVideo: true },
            "./assets/images/products/storeProducts/Star_Micronics_SP700_1-1.webp"
        ],
        status: "In Stock",
        price: "$299.99",
        link: "https://www.amazon.com/dp/B0007KPPTS?tag=optimumpay-20",
        description: "The Star Micronics SP700 is the industry-standard impact printer for kitchen order systems. Reliable, fast, and designed for high-heat environments.",
        features: [
            "Impact dot matrix printing",
            "Kitchen-grade durability",
            "Auto-cutter included",
            "Splash-resistant design",
            "Multiple interface options",
            "Dual-color printing capable"
        ],
        category: "Printers"
    }
];

// Helper function to get product by ID
function getProductById(productId) {
    return shopProducts.find(p => p.id === productId);
}

// Helper function to get related products (same category, excluding current)
function getRelatedProducts(productId, limit = 4) {
    const currentProduct = getProductById(productId);
    if (!currentProduct) return [];

    return shopProducts
        .filter(p => p.category === currentProduct.category && p.id !== productId)
        .slice(0, limit);
}
