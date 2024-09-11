<?php snippet('header') ?>

<?php snippet('event-content', ['page' => $page -> parent()]) ?>

<section id='info-modal'>
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
    </figure>  
    </div>
    <?php if($image -> caption() -> isNotEmpty()): ?>
        <div class='caption'><?= $image -> caption() ?></div>
    <?php endif ?>
    <?php endif ?>
</section>

<?php snippet('footer') ?>