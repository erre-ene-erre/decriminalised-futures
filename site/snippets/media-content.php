<?php $collection = $page->siblings()->listed()->sortBy('num'); ?>
<?php if ($image = $page->image()) : ?>
<div class='info-content lightbox' tabindex='1'>
    <div class='image-navigation'>
        <span class='previous'>
        <?php if($page -> hasPrevListed($collection)): ?>
        <a href='<?= $page -> prevListed($collection) -> url() ?>'>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 74.92 130.17" aria-label='previous' role="graphics-symbol" aria-description='previous image arrow button'>
                <path d="M65.12,0s.37,57.63-65.12,65.09c0,0,62.51,2.18,65.12,65.09l6.63-33.04c4.21-20.96,4.22-42.55.05-63.51L65.12,0Z"/>
            </svg>      
        </a>
        <?php endif ?>
        </span>
        <!-- Video Figure -->
        <?php if($image -> isVideo() ->toBool() === true):?>
        <?php 
            $isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));
            $videoW = $image -> videowidth() ?? 560;
            $videoW = $isMob ? $videoW -> toFloat() * 0.6 : $videoW;
        ?>
        <figure style="margin:0">
            <iframe class="lightbox" 
                    width="<?=$videoW?>" 
                    src="<?= $image -> videolink()?>" 
                    frameborder="0" allowfullscreen>
            </iframe>
            <?php if($image ->caption() -> isNotEmpty()): ?>
                <figcaption><?= $image -> caption() -> kt() ?></figcaption>
            <?php endif ?>
        </figure>
        <!-- End of Video Figure -->
        <?php else: ?>
        <!-- Image figure -->
        <figure class='lightbox <?=$image -> orientation()?>'>
        <img 
            loading="lazy" 
            alt="<?= $image -> alt() ?>"
        <?php if($image ->mime() === 'image/gif' or $image ->mime() === 'image/webp'): ?>
            src= "<?= $image -> url() ?>"
        <?php else: ?>
            data-src="<?= $image -> quality(72) -> url() ?>"
            data-srcset="<?= $image -> srcset() ?>"
        <?php endif ?>
        >
        <?php if($image ->caption() -> isNotEmpty()): ?>
            <figcaption><?= $image -> caption() -> kt() ?></figcaption>
        <?php endif ?>
        </figure>
        <!-- End of Image Figure -->
         <?php endif ?>
        <span class='next'>
        <?php if($page -> hasNextListed($collection)): ?>
            <a href='<?= $page -> nextListed($collection) -> url() ?>'>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 74.92 130.17" role="graphics-symbol" aria-label='next' aria-description='next image arrow button'>
                    <path d="M9.8,130.17s-.37-57.63,65.12-65.09c0,0-62.51-2.18-65.12-65.09L3.17,33.04c-4.21,20.96-4.22,42.55-.05,63.51l6.68,33.62Z"/>
                </svg> 
            </a>
        <?php endif ?>
        </span>
    </div>
    <div class='image-info'>
        <?php if($image -> info() -> isNotEmpty()): ?>
        <div class='lightbox bordered modal'>
            <div class='text-content'>
                <?= $image -> info() ?>
            </div>
        </div>
        <?php else: ?>
            <div></div>
        <?php endif ?> 
        <a  class='close' href='<?= $page -> parent() -> url() ?>'>
        <svg id="Layer_2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 70.71 70.71" role="graphics-symbol" aria-label='close'>
            <path d="M43.88,19.92L70.71,0l-19.92,26.83c-3.76,5.06-3.76,11.99,0,17.05l19.92,26.83-26.83-19.92c-5.06-3.76-11.99-3.76-17.05,0L0,70.71l19.92-26.83c3.76-5.06,3.76-11.99,0-17.05L0,0l26.83,19.92c5.06,3.76,11.99,3.76,17.05,0Z"/>
        </svg>
    </a>
    </div>
    
</div>
<?php endif ?>