
<?php 
    $events = $kirby -> collection('all-events');
    // if($tag = param('type')){
    //     $events = $kirby -> collection('all-events') ->filterBy('eventtype', param('type'), ',');
    // }else if($tag = param('subject')){
    //     $events = $kirby -> collection('all-events') ->filterBy('location', param('at'), ',');
    // }
?>

<section class='content all-events'>
    <?php foreach($events as $event): ?>
            <a class='event' href='<?= $event -> url() ?>'>
            <span><?= A::first($event->type()->split()) ?></span>
            <svg class='icon' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.76 71.42">
                    <path class="star-1" d="M39.81,0s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                    <?php if($event->images()->template('cover-icon')->isNotEmpty()): ?>
                    <mask id="svgmask">
                    <path class="star-2" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                    </mask>
                    <image xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="<?= $event ->images() ->template('cover-icon') ->first() -> url() ?>" mask="url(#svgmask)"></image>
                    <path class="star-outline" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>

                    <?php else: ?>
                    <path class="star-2" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                    <?php endif ?>
            </svg>
            <h3 class='strong'><?= $event -> title()?></h3>
            </a> 
    <?php endforeach ?>
</section>
<section class='extra-info filters'>
    <table class='filters'>
        <tr>
            <th>Year:</th>
            <td>
                <span class='year tag <?php e(!param('year'), 'active')?>' data-value=''>all</span>
                    <?php 
                        $startdates = $kirby -> collection('all-events') -> pluck('datestart', ' ', true);
                        $enddates = $kirby -> collection('all-events') -> pluck('dateend', ' ', true);
                        $alldates = array_merge($startdates, $enddates);
                        $years = array_unique(array_map(function($item){
                            return date('Y', strtotime($item));
                        }, $alldates));
                        rsort($years);
                    ?>
                    <?php foreach($years as $tag): ?>
                    <span class='year tag <?php e(param('year') == Str::replace($tag,' ','-'), 'active')?>' 
                        data-value='year:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <th>Type:</th>
            <td>
                <span class='type tag <?php e(!param('type'), 'active')?>' data-value=''>all</span>
                <?php foreach($kirby -> collection('all-events') -> pluck('type', ',', true) as $tag): ?>
                    <span class='type tag <?php e(param('type') == Str::replace($tag,' ','-'), 'active')?>' 
                        data-value='type:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <th>Subject(s):</th>
            <td>
                <span class='subject tag <?php e(!param('subject'), 'active')?>' data-value=''>all</span>
                <?php foreach($kirby -> collection('all-events') -> pluck('subject', ',', true) as $tag): ?>
                    <span class='subject tag <?php e(param('subject') == Str::replace($tag,' ','-'), 'active')?>' 
                        data-value='subject:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
    </table>
    <button><h2>Apply</h2></button>
</section>