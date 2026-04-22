<?php require_once __DIR__ . '/../config.php'; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= htmlspecialchars($title ?? 'Home'); ?> | Optimum Payment Solutions</title>

    <meta name="description" content="<?= htmlspecialchars($pageDescriptions[$page] ?? 'Discover top payment solutions and POS systems from Optimum Payment Solutions for your business needs.'); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($pageKeywords[$page] ?? 'payment solutions, POS systems, Clover, Valor, business payments'); ?>">
    <meta name="robots" content="index, follow">

    <!-- Open Graph for social sharing -->
    <meta property="og:title" content="<?= htmlspecialchars($title ?? 'Home'); ?> | Optimum Payment Solutions">
    <meta property="og:description" content="<?= htmlspecialchars($pageDescriptions[$page] ?? 'Discover top payment solutions and POS systems from Optimum Payment Solutions for your business needs.'); ?>">
    <meta property="og:image" content="<?= $base_url ?>/assets/images/og-image.jpg">
    <meta property="og:url" content="<?= $base_url ?>/<?= $page === 'home' ? '' : $page ?>">
    <meta property="og:type" content="website">

    <!-- Standard favicon -->
    <link rel="icon" href="<?= $base_url ?>/assets/images/favicon.ico" type="image/x-icon">

    <!-- PNG fallback -->
    <link rel="icon" href="<?= $base_url ?>/assets/images/favicon.png" type="image/png">

   

    <!-- Apple touch icon (for iOS / iPad) -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $base_url ?>/assets/images/apple-touch-icon.png">

    <!-- Local font fallbacks (used if Google Fonts fails) -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/fonts-fallback.css">

    <!-- Google Fonts (primary) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    
    <!-- Global Styles -->
    <?php if ($enable_preloader): ?>
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/preloader.css">
    <?php endif; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style-guide.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/banner.css">

    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/navbar.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/nav-mobilemenu.css">
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/mega-menu.css">

    <link rel="stylesheet"href="<?= $base_url ?>/assets/css/footer.css">

    <?php
    $gaTrackingId = trim((string)($env['GA_TRACKING_ID'] ?? ''));
    $hasGaTracking = $gaTrackingId !== '' && strtoupper($gaTrackingId) !== 'GA_TRACKING_ID';
    ?>
    <?php if ($hasGaTracking): ?>
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= urlencode($gaTrackingId) ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= htmlspecialchars($gaTrackingId, ENT_QUOTES, 'UTF-8') ?>');
    </script>
    <?php endif; ?>

    <?php if ($enable_preloader): ?>
    <!-- Preloader Script - Load Early -->
    <script src="<?= $base_url ?>/assets/js/preloader.js"></script>
    <?php endif; ?>

    <!-- Lottie Player - CDN with local fallback -->
    <script type="module">
        import('https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs').catch(() => {
            import('<?= $base_url ?>/assets/js/dotlottie-player.mjs');
        });
    </script>

</head>
<body>

<?php if ($enable_preloader): ?>
<!-- Full-Screen Preloader (First Visit Only) -->
<div class="page-preloader">
    <img src="<?= $base_url ?>/assets/images/logo/optimum-navLogo.webp" 
         alt="Optimum Payments" 
         class="preloader-logo">
    <p class="preloader-text">Loading your experience...</p>
    <div class="preloader-progress">
        <div class="preloader-progress-bar"></div>
    </div>
</div>
<?php endif; ?>
