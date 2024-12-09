<?php if($page -> isHomePage() or $page -> template() == 'search'): ?>
<?php else: ?>
    <footer class='mobile footer'>
        <?php if($page -> template() == 'archive'): ?>
        <h3 class='strong'>filter by</h3>
        <?php else: ?>
        <h3 class='strong'>read more</h3>
        <?php endif ?>
        <h3 class='strong open-arrow'>></h3>
    </footer> 
<?php endif ?>
</main>
    <script src="https://unpkg.com/unlazy@0.11.2/dist/unlazy.iife.js"></script>
     <!-- <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>       -->
    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://unpkg.com/@swup/fragment-plugin@1"></script>
        <script>
            let gotoURL, redirect;
            <?php if($kirby->collection('current-events')->isEmpty() && $page -> isHomePage()): ?>
            gotoURL = '<?= page('archive')->url() ?>';
            redirect = true;
            <?php endif ?>
        </script>
    <?= js('/assets/js/main.js?v=1.2.5') ?>
</body>
</html>