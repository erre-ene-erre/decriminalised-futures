<?php if ($image = $page->image()) : ?>
<div class='info-content lightbox'>
    <figure class='lightbox <?=$image -> orientation()?>'>
        <img loading="lazy" alt="<?= $image -> alt() ?>"
        <?php if($image ->mime() === 'image/gif'): ?>
            src= "<?= $image -> url() ?>"
        <?php else: ?>
            data-src="<?= $image -> resize(400) -> quality(72) -> url() ?>"
            data-srcset="<?= $image -> srcset() ?>"
            data-sizes="auto"
        <?php endif ?>
        >
        <?php if($image -> caption() -> isNotEmpty()): ?>
            <figcaption class='caption'><?= $image -> caption() ?></figcaption>
        <?php endif ?> 
    </figure> 
    <?php if($image -> info() -> isNotEmpty()): ?>
        <div class='lightbox bordered'>
            <div class='text-content'>
                <?= $image -> info() ?>
            </div>
        </div>
    <?php endif ?> 
    <a  class='close' href='<?= $page -> parent() -> url() ?>'>
        <h1>Close</h1>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 19.62 12.52">
            <polygon points="12.44 6.25 19.62 10.1 18.32 12.52 9.81 7.68 1.28 12.52 0 10.1 7.18 6.25 0 2.35 1.28 0 9.81 4.84 18.32 0 19.62 2.34 12.44 6.25"/>
        </svg>
    </a>
</div>
<?php endif ?>