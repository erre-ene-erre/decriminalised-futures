<footer class='mobile footer'>
    <?php if($page -> isHomePage()): ?>
    <h3 class='strong'>filter by</h3>
    <?php else: ?>
    <h3 class='strong'>read more</h3>
    <?php endif ?>
    <h3 class='strong open-arrow'>></h3>
</footer> 

</main>
    <script src="https://unpkg.com/unlazy@0.11.2/dist/unlazy.iife.js"></script>
     <!-- <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>       -->
    <script src="https://unpkg.com/swup@4"></script>
    <script src="https://unpkg.com/@swup/fragment-plugin@1"></script>
    <?= js('/assets/js/main.js') ?>
</body>
</html>