<?php
include __DIR__ . '/../partials/header.php';
include __DIR__ . '/../partials/banner.php';
include __DIR__ . '/../partials/navbar.php';

if ($page === 'home') {
    include __DIR__ . '/../partials/hero-home.php';
} else {
    include __DIR__ . '/../partials/hero-singularPages.php';
}
?>

<main>
    <?php include $content; ?>
</main>

<?php include __DIR__ . '/../partials/gdpr.php'; ?>
<?php include __DIR__ . '/../partials/scroll-to-top.php'; ?>
<?php include __DIR__ . '/../partials/qr-scanner-promo.php'; ?>
<?php include __DIR__ . '/../partials/notification-modal.php'; ?>
<?php include __DIR__ . '/../partials/ad-modal.php'; ?>
<?php include __DIR__ . '/../partials/newsletter-modal.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<script src="<?= $base_url ?>/assets/js/navbar-core.js" defer></script>
<script src="<?= $base_url ?>/assets/js/navbar-megamenu.js" defer></script>
<script src="<?= $base_url ?>/assets/js/navbar-mobile.js" defer></script>

