<?php
// Product detail page - JavaScript driven
$product_id = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '';
?>

<!-- Product Detail Section -->
<div class="product-detail-container" id="productDetailContainer">
    <!-- Content will be loaded by JavaScript -->
    <div class="product-loading">Loading product...</div>
</div>

<!-- Related Products Section -->
<div class="related-products-section" id="relatedProductsSection" style="display: none;">
    <h2 class="related-products-title">Related Products</h2>
    <div class="related-products-grid" id="relatedProductsGrid"></div>
</div>

<!-- Include shared products data -->
<script src="<?= $base_url ?>/assets/js/shop-products-data.js"></script>

<script>
// Get product ID from URL
const urlParams = new URLSearchParams(window.location.search);
const productId = urlParams.get('id') || '<?= $product_id ?>';
let currentProductThumbnails = [];
let is3DModeActive = false;
const magnifierSize = 170;
const magnifierZoom = 2.2;
let cubeViewerInitialized = false;
let cubeRotationX = -18;
let cubeRotationY = 28;
let cubeIsDragging = false;
let cubeLastX = 0;
let cubeLastY = 0;
let threeScene = null;
let threeCamera = null;
let threeRenderer = null;
let threeMesh = null;
let threeControls = null;
let threeBootstrapPromise = null;
let glbPreloadPromise = null;
let glbTemplateScene = null;
let glbModelReady = false;
let baseCameraDistance = 2.5;
let cameraZoomLevel = 1;
const MIN_ZOOM_LEVEL = 0.8;
const MAX_ZOOM_LEVEL = 1.25;

const PRODUCT_MODEL_FILE_MAP = {
    'clover-flex-paper': 'clover-flex-paper.glb',
    'clover-mini-paper': 'clover-mini-paper.glb',
    'clover-station-paper': 'clover-station-paper.glb',
    'clover-cash-drawer': 'clover-cash-drawer.glb',
    '2d-clover-barcode-scanner': '2d-clover-barcode-scanner.glb',
    'dejavoo-z8': 'dejavoo-z8.glb',
    'dejavoo-z9': 'dejavoo-z9.glb',
    'dejavoo-z11': 'dejavoo-z11.glb',
    'ink-ribbon-star-micronics': 'ink-ribbon-star-micronics.glb',
    'star-micronics-paper': 'star-micronics-paper.glb',
    'star-micronics-sp700': 'star-micronics-sp700.glb'
};

function getCurrentModelFileName() {
    return PRODUCT_MODEL_FILE_MAP[productId] || `${productId}.glb`;
}

function getCurrentModelPath() {
    return `<?= $base_url ?>/assets/models/${getCurrentModelFileName()}`;
}

function getFallbackModelPath() {
    return '<?= $base_url ?>/assets/models/cube.glb';
}

function loadModelWithFallback(gltfLoader, onLoad, onError) {
    const primaryPath = getCurrentModelPath();
    const fallbackPath = getFallbackModelPath();

    const tryLoad = (path, hasRetried) => {
        gltfLoader.load(
            path,
            onLoad,
            undefined,
            (error) => {
                if (!hasRetried && path !== fallbackPath) {
                    tryLoad(fallbackPath, true);
                    return;
                }

                if (onError) {
                    onError(error);
                }
            }
        );
    };

    tryLoad(primaryPath, false);
}

function ensureThreeReady() {
    if (window.THREE && window.GLTFLoader && window.DRACOLoader) {
        return Promise.resolve();
    }

    if (!threeBootstrapPromise) {
        threeBootstrapPromise = Promise.all([
            import('<?= $base_url ?>/assets/js/vendor/three.module.js'),
            import('<?= $base_url ?>/assets/js/vendor/GLTFLoader.js'),
            import('<?= $base_url ?>/assets/js/vendor/DRACOLoader.js')
        ]).then(([THREE, gltfModule, dracoModule]) => {
            window.THREE = THREE;
            window.GLTFLoader = gltfModule.GLTFLoader;
            window.DRACOLoader = dracoModule.DRACOLoader;
        });
    }

    return threeBootstrapPromise;
}

function createConfiguredGLTFLoader() {
    const gltfLoader = new window.GLTFLoader();

    if (window.DRACOLoader) {
        const dracoLoader = new window.DRACOLoader();
        dracoLoader.setDecoderPath('<?= $base_url ?>/assets/js/vendor/draco/gltf/');
        gltfLoader.setDRACOLoader(dracoLoader);
    }

    return gltfLoader;
}

function update3DThumbnailLoadingState() {
    const threeDThumbs = document.querySelectorAll('.product-thumbnail-item[data-is-3d="1"]');
    threeDThumbs.forEach((thumb) => {
        if (glbModelReady) {
            thumb.classList.remove('is-loading-3d');
        } else {
            thumb.classList.add('is-loading-3d');
        }
    });
}

function preloadGLBModel() {
    if (glbPreloadPromise || glbModelReady || !currentProductThumbnails.some((thumb) => thumb.is3d)) {
        return glbPreloadPromise;
    }

    update3DThumbnailLoadingState();

    glbPreloadPromise = ensureThreeReady()
        .then(() => {
            const gltfLoader = createConfiguredGLTFLoader();

            return new Promise((resolve, reject) => {
                loadModelWithFallback(
                    gltfLoader,
                    (gltf) => {
                        glbTemplateScene = gltf.scene;
                        glbModelReady = true;
                        update3DThumbnailLoadingState();
                        resolve(gltf);
                    },
                    (error) => {
                        console.error('Error preloading GLB model:', error);
                        update3DThumbnailLoadingState();
                        reject(error);
                    }
                );
            });
        })
        .catch((error) => {
            console.error('GLB preload failed:', error);
            return null;
        });

    return glbPreloadPromise;
}

function buildProductThumbnails(product) {
    const sourceImages = Array.isArray(product.images) && product.images.length
        ? product.images
        : [product.image];

    const thumbnails = sourceImages.slice(0, 4).map((item) => {
        if (typeof item === 'string') {
            return { src: item, is3d: false, isVideo: false };
        }

        return {
            src: item.src || product.image,
            is3d: !!item.is3d,
            isVideo: !!item.isVideo
        };
    });

    while (thumbnails.length < 4) {
        thumbnails.push({ src: product.image, is3d: false, isVideo: false });
    }

    const has3dThumbnail = thumbnails.some((thumb) => thumb.is3d);
    if (!has3dThumbnail && thumbnails.length > 0) {
        thumbnails[thumbnails.length - 1] = {
            ...thumbnails[thumbnails.length - 1],
            is3d: true
        };
    }

    return thumbnails;
}

function applyCubeRotation() {
    if (!threeMesh) return;
    threeMesh.rotation.x = (cubeRotationX * Math.PI) / 180;
    threeMesh.rotation.y = (cubeRotationY * Math.PI) / 180;
}

function fitModelToCamera(model, fillRatio = 0.75) {
    if (!model || !threeCamera || !window.THREE) return;

    const box = new window.THREE.Box3().setFromObject(model);
    if (box.isEmpty()) return;

    const center = box.getCenter(new window.THREE.Vector3());
    const size = box.getSize(new window.THREE.Vector3());
    const radius = Math.max(size.x, size.y, size.z) * 0.5;

    model.position.sub(center);

    const verticalFov = (threeCamera.fov * Math.PI) / 180;
    const horizontalFov = 2 * Math.atan(Math.tan(verticalFov / 2) * threeCamera.aspect);

    const distanceForHeight = radius / (Math.tan(verticalFov / 2) * fillRatio);
    const distanceForWidth = radius / (Math.tan(horizontalFov / 2) * fillRatio);
    const distance = Math.max(distanceForHeight, distanceForWidth);

    baseCameraDistance = distance;
    cameraZoomLevel = 1;

    threeCamera.position.set(0, 0, baseCameraDistance / cameraZoomLevel);
    threeCamera.near = Math.max(0.01, distance / 100);
    threeCamera.far = Math.max(1000, distance * 20);
    threeCamera.lookAt(0, 0, 0);
    threeCamera.updateProjectionMatrix();
}

function applyCameraZoom() {
    if (!threeCamera) return;

    threeCamera.position.z = baseCameraDistance / cameraZoomLevel;
    threeCamera.lookAt(0, 0, 0);
}

function initializeThreeJS() {
    const viewerEl = document.getElementById('product3DViewer');
    if (!viewerEl || threeScene || !window.THREE) return;

    // Scene setup
    threeScene = new window.THREE.Scene();
    threeScene.background = new window.THREE.Color(0xf5f5f5);

    // Camera
    const width = viewerEl.clientWidth || 400;
    const height = viewerEl.clientHeight || 400;
    threeCamera = new window.THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    threeCamera.position.z = 2.5;

    // Renderer
    threeRenderer = new window.THREE.WebGLRenderer({ antialias: true, alpha: true });
    threeRenderer.setSize(width, height);
    threeRenderer.setPixelRatio(window.devicePixelRatio);
    viewerEl.innerHTML = '';
    viewerEl.appendChild(threeRenderer.domElement);

    // Lighting
    const ambientLight = new window.THREE.AmbientLight(0xffffff, 0.7);
    threeScene.add(ambientLight);

    const directionalLight = new window.THREE.DirectionalLight(0xffffff, 0.8);
    directionalLight.position.set(5, 5, 5);
    threeScene.add(directionalLight);

    // Create textured cube
    createTexturedCube();

    // Mouse interactions
    setupThreeJSInteractions(viewerEl);

    // Animation loop
    animateThreeJS();
}

function createTexturedCube() {
    // Load GLB model
    if (!window.GLTFLoader) {
        console.warn('GLTFLoader not available, using fallback textured cube');
        createFallbackCube();
        return;
    }

    if (glbModelReady && glbTemplateScene) {
        threeMesh = glbTemplateScene.clone(true);
        fitModelToCamera(threeMesh);
        threeMesh.rotation.x = (cubeRotationX * Math.PI) / 180;
        threeMesh.rotation.y = (cubeRotationY * Math.PI) / 180;
        threeScene.add(threeMesh);
        return;
    }

    const gltfLoader = createConfiguredGLTFLoader();

    loadModelWithFallback(
        gltfLoader,
        (gltf) => {
            threeMesh = gltf.scene;
            glbTemplateScene = gltf.scene;
            glbModelReady = true;
            update3DThumbnailLoadingState();
            fitModelToCamera(threeMesh);
            threeMesh.rotation.x = (cubeRotationX * Math.PI) / 180;
            threeMesh.rotation.y = (cubeRotationY * Math.PI) / 180;
            threeScene.add(threeMesh);
        },
        (error) => {
            console.error('Error loading GLB model:', error);
            // Fallback to textured cube if model fails to load
            createFallbackCube();
        }
    );
}

function createFallbackCube() {
    const mainImage = document.getElementById('mainProductImage');
    const imageUrl = mainImage ? mainImage.src : '';

    const textureLoader = new window.THREE.TextureLoader();
    const texture = imageUrl ? textureLoader.load(imageUrl) : createPlaceholderTexture();

    const geometry = new window.THREE.BoxGeometry(1.8, 1.8, 1.8);
    const material = new window.THREE.MeshPhongMaterial({ map: texture });
    threeMesh = new window.THREE.Mesh(geometry, material);

    threeMesh.rotation.x = (cubeRotationX * Math.PI) / 180;
    threeMesh.rotation.y = (cubeRotationY * Math.PI) / 180;

    threeScene.add(threeMesh);
    fitModelToCamera(threeMesh);
}

function createPlaceholderTexture() {
    const canvas = document.createElement('canvas');
    canvas.width = 512;
    canvas.height = 512;
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#e0e0e0';
    ctx.fillRect(0, 0, 512, 512);
    ctx.fillStyle = '#999';
    ctx.font = '48px Arial';
    ctx.textAlign = 'center';
    ctx.fillText('Product', 256, 230);
    ctx.fillText('Image', 256, 290);

    const texture = new window.THREE.CanvasTexture(canvas);
    return texture;
}

function setupThreeJSInteractions(viewerEl) {
    const stopDrag = () => {
        cubeIsDragging = false;
        viewerEl.classList.remove('dragging');
    };

    viewerEl.addEventListener('pointerdown', (event) => {
        cubeIsDragging = true;
        cubeLastX = event.clientX;
        cubeLastY = event.clientY;
        viewerEl.classList.add('dragging');
        viewerEl.setPointerCapture(event.pointerId);
    });

    viewerEl.addEventListener('pointermove', (event) => {
        if (!cubeIsDragging || !is3DModeActive) return;

        const deltaX = event.clientX - cubeLastX;
        const deltaY = event.clientY - cubeLastY;
        cubeLastX = event.clientX;
        cubeLastY = event.clientY;

        cubeRotationY += deltaX * 0.6;
        cubeRotationX += deltaY * 0.5;
        cubeRotationX = Math.max(-70, Math.min(70, cubeRotationX));
        applyCubeRotation();
    });

    viewerEl.addEventListener('pointerup', stopDrag);
    viewerEl.addEventListener('pointercancel', stopDrag);
    viewerEl.addEventListener('pointerleave', stopDrag);

    viewerEl.addEventListener('wheel', (event) => {
        if (!is3DModeActive) return;

        event.preventDefault();
        const zoomStep = event.deltaY > 0 ? -0.05 : 0.05;
        cameraZoomLevel = Math.max(MIN_ZOOM_LEVEL, Math.min(MAX_ZOOM_LEVEL, cameraZoomLevel + zoomStep));
        applyCameraZoom();
    }, { passive: false });
}

function animateThreeJS() {
    requestAnimationFrame(animateThreeJS);

    if (threeRenderer && threeScene && threeCamera) {
        threeRenderer.render(threeScene, threeCamera);
    }
}

function updateThreeJSTexture(imageUrl) {
    if (!threeMesh) return;

    const textureLoader = new window.THREE.TextureLoader();
    const texture = textureLoader.load(imageUrl);

    if (threeMesh.material) {
        threeMesh.material.map = texture;
        threeMesh.material.needsUpdate = true;
        return;
    }

    if (threeMesh.traverse) {
        threeMesh.traverse((node) => {
            if (node.isMesh && node.material) {
                node.material.map = texture;
                node.material.needsUpdate = true;
            }
        });
    }
}

function initializeCubeViewer() {
    if (cubeViewerInitialized) return;

    ensureThreeReady()
        .then(() => {
            if (cubeViewerInitialized) return;
            initializeThreeJS();
            cubeViewerInitialized = true;
        })
        .catch((error) => {
            console.error('Failed to bootstrap Three.js modules:', error);
        });
}



function set3DMode(enabled) {
    const imageWrapper = document.querySelector('.product-detail-image-wrapper');
    const imageStage = document.getElementById('mainImageStage');
    const mainImage = document.getElementById('mainProductImage');
    const mainVideo = document.getElementById('mainProductVideo');
    const viewerEl = document.getElementById('product3DViewer');

    is3DModeActive = !!enabled;

    if (!imageWrapper || !imageStage || !mainImage || !viewerEl) {
        return;
    }

    if (is3DModeActive) {
        imageWrapper.classList.add('is-3d');
        hideMagnifier();
        mainImage.style.display = 'none';
        if (mainVideo) mainVideo.style.display = 'none';
        viewerEl.style.display = 'block';
        initializeCubeViewer();
    } else {
        imageWrapper.classList.remove('is-3d');
        viewerEl.style.display = 'none';
        mainImage.style.display = 'block';
        if (mainVideo) mainVideo.style.display = 'none';
    }
}

function setVideoMode(enabled, videoSrc = '') {
    const imageWrapper = document.querySelector('.product-detail-image-wrapper');
    const mainImage = document.getElementById('mainProductImage');
    const mainVideo = document.getElementById('mainProductVideo');
    const viewerEl = document.getElementById('product3DViewer');

    if (!imageWrapper || !mainImage || !mainVideo || !viewerEl) {
        return;
    }

    if (enabled && videoSrc) {
        imageWrapper.classList.remove('is-3d');
        imageWrapper.classList.add('is-video');
        hideMagnifier();
        mainImage.style.display = 'none';
        viewerEl.style.display = 'none';
        mainVideo.src = videoSrc;
        mainVideo.style.display = 'block';
        mainVideo.load();
    } else {
        imageWrapper.classList.remove('is-video');
        mainVideo.style.display = 'none';
        mainVideo.pause();
        mainVideo.src = '';
        mainImage.style.display = 'block';
    }
}

function hideMagnifier() {
    const lens = document.getElementById('imageMagnifierLens');
    if (!lens) {
        return;
    }

    lens.classList.remove('active');
}

function updateMagnifier(event) {
    if (is3DModeActive) {
        hideMagnifier();
        return;
    }

    const imageStage = document.getElementById('mainImageStage');
    const mainImage = document.getElementById('mainProductImage');
    const lens = document.getElementById('imageMagnifierLens');
    if (!imageStage || !mainImage || !lens) {
        return;
    }

    const stageRect = imageStage.getBoundingClientRect();
    const imageRect = mainImage.getBoundingClientRect();
    const pointerX = event.clientX;
    const pointerY = event.clientY;

    if (
        pointerX < imageRect.left ||
        pointerX > imageRect.right ||
        pointerY < imageRect.top ||
        pointerY > imageRect.bottom
    ) {
        hideMagnifier();
        return;
    }

    const xInImage = pointerX - imageRect.left;
    const yInImage = pointerY - imageRect.top;
    const lensHalf = magnifierSize / 2;
    let lensLeft = pointerX - stageRect.left - lensHalf;
    let lensTop = pointerY - stageRect.top - lensHalf;

    lensLeft = Math.max(0, Math.min(stageRect.width - magnifierSize, lensLeft));
    lensTop = Math.max(0, Math.min(stageRect.height - magnifierSize, lensTop));

    lens.style.left = `${lensLeft}px`;
    lens.style.top = `${lensTop}px`;
    lens.style.width = `${magnifierSize}px`;
    lens.style.height = `${magnifierSize}px`;
    lens.style.backgroundImage = `url('${mainImage.src}')`;
    lens.style.backgroundSize = `${imageRect.width * magnifierZoom}px ${imageRect.height * magnifierZoom}px`;
    lens.style.backgroundPosition = `${-(xInImage * magnifierZoom - lensHalf)}px ${-(yInImage * magnifierZoom - lensHalf)}px`;
    lens.classList.add('active');
}

function initialize3DInteractions() {
    const imageStage = document.getElementById('mainImageStage');
    if (!imageStage) {
        return;
    }

    imageStage.addEventListener('pointermove', (event) => {
        if (!is3DModeActive) {
            updateMagnifier(event);
        }
    });

    imageStage.addEventListener('pointerenter', (event) => {
        if (!is3DModeActive) {
            updateMagnifier(event);
        }
    });

    imageStage.addEventListener('pointerleave', () => {
        hideMagnifier();
    });
}

// Render product detail
function renderProductDetail() {
    const container = document.getElementById('productDetailContainer');
    const product = getProductById(productId);
    
    if (!product) {
        container.innerHTML = `
            <div class="product-not-found">
                <h1>Product Not Found</h1>
                <p>Sorry, the product you're looking for doesn't exist.</p>
                <a href="shop" class="btn-back-to-shop">← Back to Shop</a>
            </div>
        `;
        return;
    }
    
    // Update page title
    document.title = product.name + ' - Optimum Payments Shop';
    currentProductThumbnails = buildProductThumbnails(product);
    
    // Render product detail
    container.innerHTML = `
        <div class="product-detail-wrapper">
            <!-- Breadcrumb -->
            <nav class="product-breadcrumb">
                <a href="/">Home</a>
                <span class="breadcrumb-separator">›</span>
                <a href="shop">Shop</a>
                <span class="breadcrumb-separator">›</span>
                <span class="breadcrumb-current">${product.name}</span>
            </nav>
            
            <div class="product-detail-content">
                <!-- Product Image Gallery -->
                <div class="product-detail-image-wrapper">
                    <span class="product-detail-badge ${product.status === 'In Stock' ? 'in-stock' : 'available'}">${product.status}</span>
                    <div class="product-main-image-stage" id="mainImageStage">
                        <img src="${currentProductThumbnails[0].src}" alt="${product.name}" class="product-detail-image" id="mainProductImage">
                        <video class="product-detail-video" id="mainProductVideo" controls controlsList="nodownload" style="display:none;"></video>
                        <div class="product-3d-viewer" id="product3DViewer" aria-hidden="true"></div>
                        <div class="product-image-magnifier-lens" id="imageMagnifierLens" aria-hidden="true"></div>
                        <span class="product-3d-hint">Drag to rotate cube</span>
                    </div>
                    
                    <!-- Thumbnail Gallery -->
                    <div class="product-thumbnails">
                        ${currentProductThumbnails.map((thumb, index) => `
                            <div class="product-thumbnail-item ${index === 0 ? 'active' : ''} ${thumb.is3d && !glbModelReady ? 'is-loading-3d' : ''}" onclick="changeMainImage(${index})" data-index="${index}" data-is-3d="${thumb.is3d ? 1 : 0}" data-is-video="${thumb.isVideo ? 1 : 0}">
                                <img src="${thumb.src}" 
                                     alt="${product.name} - View ${index + 1}" 
                                     class="product-thumbnail">
                                ${thumb.is3d ? `<span class="product-thumbnail-label">${glbModelReady ? '3D' : '3D…'}</span>` : ''}
                                ${thumb.isVideo ? `<span class="product-thumbnail-label video-label">▶</span>` : ''}
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="product-detail-info">
                    <span class="product-detail-category">${product.category}</span>
                    <h1 class="product-detail-title">${product.name}</h1>
                    
                    <p class="product-detail-description">${product.description}</p>
                    
                    <div class="product-detail-features">
                        <h3>Features</h3>
                        <ul>
                            ${product.features.map(f => `<li>${f}</li>`).join('')}
                        </ul>
                    </div>
                    
                    <div class="product-detail-actions">
                        <a href="${product.link}" target="_blank" rel="noopener" class="btn-buy-now">Buy Now on Amazon</a>
                        <a href="shop" class="btn-back-to-shop">← Back to Shop</a>
                    </div>
                </div>
            </div>
        </div>
    `;

    initialize3DInteractions();
    preloadGLBModel();
    set3DMode(currentProductThumbnails[0]?.is3d);
    
    // Render related products
    renderRelatedProducts();
}

// Change main product image when thumbnail is clicked
function changeMainImage(index) {
    if (!currentProductThumbnails[index]) {
        return;
    }

    const currentThumb = currentProductThumbnails[index];

    if (currentThumb.is3d && !glbModelReady) {
        preloadGLBModel();
        return;
    }

    const imageSrc = currentThumb.src;
    const mainImage = document.getElementById('mainProductImage');
    const thumbnails = document.querySelectorAll('.product-thumbnail-item');
    
    // Handle video mode
    if (currentThumb.isVideo) {
        setVideoMode(true, imageSrc);
        set3DMode(false);
    }
    // Handle 3D mode
    else if (currentThumb.is3d) {
        setVideoMode(false);
        set3DMode(true);
    }
    // Handle regular image mode
    else {
        setVideoMode(false);
        set3DMode(false);
        
        // Update main image with smooth transition
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = imageSrc;
            mainImage.style.opacity = '1';
            hideMagnifier();
        }, 200);
    }
    
    // Update active thumbnail
    thumbnails.forEach((thumb, i) => {
        if (i === index) {
            thumb.classList.add('active');
        } else {
            thumb.classList.remove('active');
        }
    });
}

// Update cube texture with new product image
function updateCubeTexture(imageUrl) {
    updateThreeJSTexture(imageUrl);
}

// Render related products
function renderRelatedProducts() {
    const section = document.getElementById('relatedProductsSection');
    const grid = document.getElementById('relatedProductsGrid');
    const relatedProducts = getRelatedProducts(productId, 4);
    
    if (relatedProducts.length === 0) {
        section.style.display = 'none';
        return;
    }
    
    section.style.display = 'block';
    grid.innerHTML = relatedProducts.map(product => `
        <a href="shop-product?id=${product.id}" class="related-product-card">
            <div class="related-product-image-wrapper">
                <img src="${product.image}" alt="${product.name}" class="related-product-image">
            </div>
            <div class="related-product-info">
                <h4 class="related-product-name">${product.name}</h4>
            </div>
        </a>
    `).join('');
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', renderProductDetail);
</script>

<link rel="stylesheet" href="<?= $base_url ?>/assets/css/shop.css">

<style>
/* ========================================
   PRODUCT DETAIL PAGE STYLES
======================================== */

.product-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.product-loading {
    text-align: center;
    padding: 4rem;
    color: #666;
    font-size: 1.125rem;
}

.product-not-found {
    text-align: center;
    padding: 4rem 2rem;
}

.product-not-found h1 {
    font-size: 2rem;
    color: #333;
    margin-bottom: 1rem;
}

.product-not-found p {
    color: #666;
    margin-bottom: 2rem;
}

/* Breadcrumb */
.product-breadcrumb {
    margin-bottom: 2rem;
    font-size: 0.875rem;
    color: #666;
}

.product-breadcrumb a {
    color: #1c6ba0;
    text-decoration: none;
}

.product-breadcrumb a:hover {
    text-decoration: underline;
}

.breadcrumb-separator {
    margin: 0 0.5rem;
    color: #999;
}

.breadcrumb-current {
    color: #333;
}

/* Product Detail Layout */
.product-detail-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
}

@media (max-width: 768px) {
        .product-detail-image-wrapper {
            flex-direction: column;
        }

        .product-thumbnails {
            flex-direction: row;
            flex-wrap: wrap;
        }

    .product-detail-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

/* Product Image */
.product-detail-image-wrapper {
    position: relative;
    background: #f8f9fa;
    border-radius: 12px;
    padding: 2rem;
    display: flex;
    flex-direction: row-reverse;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
}

.product-detail-image {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    transition: opacity 0.3s ease;
    flex: 1;
}

.product-main-image-stage {
    position: relative;
    width: 100%;
    min-height: 360px;
    display: flex;
    align-items: center;
    justify-content: center;
    perspective: 1200px;
    overflow: hidden;
}

.product-3d-viewer {
    position: absolute;
    inset: 0;
    display: none;
    z-index: 2;
    cursor: grab;
    touch-action: none;
}

.product-3d-viewer.dragging {
    cursor: grabbing;
}

.product-3d-scene {
    width: 100%;
    height: 100%;
    position: relative;
}

.product-3d-scene canvas {
    display: block;
    width: 100% !important;
    height: 100% !important;
}

.product-detail-image-wrapper:not(.is-3d) .product-main-image-stage {
    cursor: zoom-in;
}

.product-detail-image-wrapper:not(.is-3d) .product-detail-image {
    transition: opacity 0.3s ease;
}

.product-image-magnifier-lens {
    position: absolute;
    display: none;
    border-radius: 4px;
    border: 2px solid rgba(28, 107, 160, 0.9);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
    background-repeat: no-repeat;
    background-color: #fff;
    pointer-events: none;
    z-index: 5;
}

.product-image-magnifier-lens.active {
    display: block;
}

.product-detail-image-wrapper.is-3d .product-main-image-stage {
    cursor: grab;
    touch-action: none;
}

.product-detail-video {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 12px;
}

.product-detail-image-wrapper.is-video .product-main-image-stage {
    cursor: default;
}

.product-thumbnail-label.video-label {
    background: linear-gradient(135deg, #e53935 0%, #c62828 100%);
    font-size: 11px;
    padding: 3px 8px;
}

.product-detail-image-wrapper.is-3d .product-main-image-stage.dragging {
    cursor: grabbing;
}

.product-detail-image-wrapper.is-3d .product-detail-image {
    transition: opacity 0.3s ease, transform 0.08s linear;
    will-change: transform;
}

.product-3d-hint {
    position: absolute;
    bottom: 8px;
    right: 8px;
    background: rgba(28, 107, 160, 0.9);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 600;
    padding: 0.3rem 0.5rem;
    border-radius: 4px;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
    z-index: 6;
}

.product-thumbnail-item.is-loading-3d {
    opacity: 0.45;
    filter: grayscale(0.4);
    pointer-events: none;
}

.product-detail-image-wrapper.is-3d .product-3d-hint {
    opacity: 1;
}

/* Product Thumbnails */
.product-thumbnails {
        flex-direction: column;
    display: flex;
    gap: 1rem;
    justify-content: center;
}

.product-thumbnail-item {
    position: relative;
    border: 2px solid transparent;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: white;
    padding: 0.25rem;
}

.product-thumbnail-item:hover {
    border-color: #1c6ba0;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(28, 107, 160, 0.2);
}

.product-thumbnail-item.active {
    border-color: #1c6ba0;
    box-shadow: 0 0 0 2px rgba(28, 107, 160, 0.1);
}

.product-thumbnail {
    width: 80px;
    height: 80px;
    aspect-ratio: 1 / 1;
    object-fit: contain;
    border-radius: 8px;
    padding: 0.5rem;
}

.product-thumbnail-label {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #1c6ba0;
    color: #fff;
    font-size: 0.625rem;
    font-weight: 700;
    line-height: 1;
    padding: 0.2rem 0.35rem;
    border-radius: 4px;
    text-transform: uppercase;
}

@media (max-width: 768px) {
    .product-main-image-stage {
        min-height: 280px;
    }

    .product-thumbnail {
        width: 60px;
        height: 60px;
    }
}

.product-detail-badge {
    position: absolute;
    top: 1rem;
    left: 1rem;
    padding: 0.375rem 0.75rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.product-detail-badge.in-stock {
    background: #28a745;
    color: white;
}

.product-detail-badge.available {
    background: #ffc107;
    color: #333;
}

/* Product Info */
.product-detail-info {
    padding: 1rem 0;
}

.product-detail-category {
    display: inline-block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #1c6ba0;
    background: #e8f4fc;
    padding: 0.25rem 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.product-detail-title {
    font-size: 2rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 1.5rem 0;
    line-height: 1.2;
}

.product-detail-description {
    font-size: 1rem;
    line-height: 1.7;
    color: #555;
    margin-bottom: 2rem;
}

/* Features */
.product-detail-features h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 1rem 0;
}

.product-detail-features ul {
    list-style: none;
    padding: 0;
    margin: 0 0 2rem 0;
}

.product-detail-features li {
    position: relative;
    padding-left: 1.5rem;
    margin-bottom: 0.5rem;
    color: #555;
    line-height: 1.5;
}

.product-detail-features li::before {
    content: "✓";
    position: absolute;
    left: 0;
    color: #28a745;
    font-weight: bold;
}

/* Actions */
.product-detail-actions {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.btn-buy-now {
    display: inline-block;
    background: #1c6ba0;
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 600;
    text-align: center;
    text-decoration: none;
    transition: background 0.2s ease;
}

.btn-buy-now:hover {
    background: #155a8a;
}

.btn-back-to-shop {
    display: inline-block;
    color: #1c6ba0;
    font-size: 0.875rem;
    text-decoration: none;
}

.btn-back-to-shop:hover {
    text-decoration: underline;
}

/* Related Products */
.related-products-section {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem 4rem;
}

.related-products-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #333;
    margin: 0 0 1.5rem 0;
}

.related-products-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1.5rem;
}

@media (max-width: 992px) {
    .related-products-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .related-products-grid {
        grid-template-columns: 1fr;
    }
}

.related-product-card {
    background: white;
    border: 1px solid #eee;
    border-radius: 8px;
    overflow: hidden;
    text-decoration: none;
    transition: box-shadow 0.2s ease, transform 0.2s ease;
}

.related-product-card:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.related-product-image-wrapper {
    background: #f8f9fa;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px;
}

.related-product-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.related-product-info {
    padding: 1rem;
}

.related-product-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    margin: 0 0 0.5rem 0;
    line-height: 1.3;
}

.related-product-price {
    font-size: 0.875rem;
    font-weight: 700;
    color: #1c6ba0;
    margin: 0;
}
</style>
