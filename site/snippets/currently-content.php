
<div class='header currently'>
<h1>    
    Current / Upcoming
</h1>
</div>

<section class='content currently'>
    <?php foreach($kirby -> collection('current-events') as $current): ?>
         <a class='current' href='<?= $current -> url() ?>'>
            <svg class='icon' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 787.16 781.15" role="graphics-symbol" aria-hidden="true">
                <?php if($current->images()->template('cover-icon')->isNotEmpty()): ?>
                <mask id="svgmask">
                <path class="star-m" d="M396.38,0S393.39,358.5,0,396.57c0,0,348.62-17.61,396.38,384.58,0,0-2.22-345.81,390.78-390.57,0,0-375.1-13.06-390.78-390.58Z"/>
                </mask>
                <image xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= $current ->images() ->template('cover-icon') ->first() ->crop(1000) -> url() ?>" mask="url(#svgmask)"></image>
                <path class="star-outline" d="M396.38,0S393.39,358.5,0,396.57c0,0,348.62-17.61,396.38,384.58,0,0-2.22-345.81,390.78-390.57,0,0-375.1-13.06-390.78-390.58Z"/>
                <?php else: ?>
                <path class="star" d="M396.38,0S393.39,358.5,0,396.57c0,0,348.62-17.61,396.38,384.58,0,0-2.22-345.81,390.78-390.57,0,0-375.1-13.06-390.78-390.58Z"/>
                <?php endif ?>
            </svg>
            <h2><?= $current -> title()?></h2>
        </a> 
    <?php endforeach ?>
</section>