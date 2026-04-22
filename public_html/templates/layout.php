<?php include __DIR__ . '/../partials/header.php'; ?>
<?php include __DIR__ . '/../partials/banner.php'; ?>
<?php include __DIR__ . '/../partials/navbar.php'; ?>

<?php if ($page === 'home'): ?>
    <?php include __DIR__ . '/../partials/hero-home.php'; ?>
<?php else: ?>
    <?php include __DIR__ . '/../partials/hero-singularPages.php'; ?>
<?php endif; ?>

<main>
    <?php include $content; ?>
</main>

<?php include __DIR__ . '/../partials/ourpartners-grid.php'; ?>
<?php include __DIR__ . '/../partials/gdpr.php'; ?>
<?php include __DIR__ . '/../partials/scroll-to-top.php'; ?>
<?php include __DIR__ . '/../partials/notification-modal.php'; ?>
<?php include __DIR__ . '/../partials/ad-modal.php'; ?>
<?php include __DIR__ . '/../partials/newsletter-modal.php'; ?>
<?php include __DIR__ . '/../partials/footer.php'; ?>

<!-- Core JS -->
<script src="<?= $base_url ?>/assets/js/homeHero.js" defer></script>
<script src="<?= $base_url ?>/assets/js/topInfoBar.js" defer></script>
<script src="<?= $base_url ?>/assets/js/topNavigationBar.js" defer></script>
<script src="<?= $base_url ?>/assets/js/megamenu.js" defer></script>
<script src="<?= $base_url ?>/assets/js/minimenu.js" defer></script>
<script src="<?= $base_url ?>/assets/js/mobileNavigationMenu.js" defer></script>
<script src="<?= $base_url ?>/assets/js/testimonial-review.js" defer></script>
<script src="<?= $base_url ?>/assets/js/topSellingProd.js" defer></script>

</body>
</html>
