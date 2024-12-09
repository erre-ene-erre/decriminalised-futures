<section class='content'>
    <h1 class='event-title'><?= $page -> title() ?></h1>

    <?php if($page -> audio() ->isNotEmpty()): ?>
    <?php foreach ($page -> files() -> template('sound-file') as $soundfile): ?>
        <div class="audio-player">
            <audio preload="metadata" src="<?= $soundfile->url() ?>" type="<?= $soundfile->mime() ?>">
                <p>Your browser does not support HTML5 audio.</p>
            </audio>
            <div class='media-title'>
                <?= $soundfile -> trackname() -> or('Listen') ?>
            </div>
            <div class='media-controllers'>
                <div class='play-icon'>
                    <svg class="play media-button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 103.09 119">
                        <polygon points="8.11 59.52 0 0 47.49 36.79 103.09 59.52 47.49 82.25 0 119.04 8.11 59.52"/>
                    </svg>
                    <svg class="pause media-button hidden" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 61.53 119">
                        <polygon points="20.11 0 6.7 0 0 59.44 6.7 118.87 20.11 118.87 26.82 59.44 20.11 0"/>
                        <polygon points="54.83 .13 41.42 .13 34.71 59.56 41.42 119 54.83 119 61.53 59.56 54.83 .13"/>
                    </svg>
                </div>
                <div class='controllers'>
                    <input type="range" autocomplete="off" class="seek-slider" max="100" value="0">
                    <div class='time-range'>
                        <span class="time current-time">0:00</span>
                        <span class="time duration">0:00</span>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach ?>
    <?php endif ?>
    
    
    <?php if($page -> hasChildren()):?>
    <div class='gallery'>
    <?php foreach($page -> children() -> template('media-file') -> sortBy('num') as $child): ?>
        <?php if ($image = $child->image()) : ?>
                <figure class='gallery-item'>
                <?php if($image ->mime() === 'video/mp4'): ?>
                    <video class="image" controls playsinline>
                        <source src="<?= $image -> url() ?>" 
                                type="<?= $image -> mime() ?>">
                    </video>
                <?php else: ?>
                    <a href="<?= $child->url() ?>">
                    <img loading="lazy" class='<?= $image -> orientation() ?>' alt="<?= $image -> alt() ?>"
                    <?php if($image ->mime() === 'image/gif'): ?>
                        src= "<?= $image -> url() ?>"
                    <?php else: ?>
                        data-src="<?= $image -> url() ?>"
                        data-srcset="<?= $image -> srcset() ?>"
                        data-sizes="auto"
                    <?php endif ?>
                    >
                    </a>
                <?php endif ?>
                <?php if($image ->caption() -> isNotEmpty()): ?>
                <figcaption><?= $image -> caption() -> kt() ?></figcaption>
                <?php endif ?>
            </figure>
        <?php endif ?>
    <?php endforeach ?>
    </div>
    <?php endif ?>

    <div class='info'>
        <?= $page -> textcontent() ?>
    </div>
</section>

<section class='extra-info modal'>

    <div class='<?= $page->highlight() -> isNotEmpty() ? 'bordered' : '' ?> highlight'>
        <?= $page -> highlight() ?>
    </div>
    <table class='categories'>
        <tr>
            <th>Year:</th>
            <td>
                <span><?= $page -> datestart() -> toDate('Y') ?></span>
                <?php if($page -> dateend() -> isNotEmpty() && $page -> dateend() -> toDate('Y') != $page -> datestart() -> toDate('Y')): ?>
                <span><?= $page -> dateend() -> toDate('Y') ?></span>
                <?php endif ?>
            </td>
        </tr>
        <?php if($page -> type() -> isNotEmpty()): ?>
        <tr>
            <th>Type:</th>
            <td>
            <?php foreach ($page->type()->split() as $type): ?>
                <span><?= $type ?></span>
            <?php endforeach ?>
            </td>
        </tr>
        <?php endif ?>
        <?php if($page -> series() -> isNotEmpty()): ?>
        <tr>
            <th>Series:</th>
            <td>
            <?php foreach ($page->series()->split() as $series): ?>
                <span><?= $series ?></span>
            <?php endforeach ?>
            </td>
        </tr>
        <?php endif ?>
        <?php if($page -> subject() -> isNotEmpty()): ?>
        <tr>
            <th>Subject(s):</th>
            <td>
            <?php foreach ($page->subject()->split() as $subject): ?>
                <span><?= $subject ?></span>
            <?php endforeach ?>
            </td>
        </tr>
        <?php endif ?>
    </table>
</section>