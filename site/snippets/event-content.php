<section class='content'>
    <h1 class='event-title'><?= $page -> title() ?></h1>
    <?php if($page -> hasChildren()):?>
    <div class='gallery'>
    <?php foreach($page -> children() -> template('media-file') as $child): ?>
        <?php if ($image = $child->image()) : ?>
                <figure class='gallery-item'>
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
                <?php if($image ->caption() -> isNotEmpty()): ?>
                <figcaption><?= $image -> caption() ?></figcaption>
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

<section class='extra-info'>
    <div class='bordered highlight'>
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
        <tr>
            <th>Type:</th>
            <td>
            <?php foreach ($page->type()->split() as $type): ?>
                <span><?= $type ?></span>
            <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <th>Subject(s):</th>
            <td>
            <?php foreach ($page->subject()->split() as $subject): ?>
                <span><?= $subject ?></span>
            <?php endforeach ?>
            </td>
        </tr>
    </table>
</section>