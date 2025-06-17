
<?php 
    $events = $kirby -> collection('all-events');
    if ($yearsParam = param('year')) {
        $selectedYears = explode('+', $yearsParam); // Split by '+'
        $events = $events->filter(fn($child) => 
            in_array($child->datestart()->toDate('Y'), $selectedYears) or 
            in_array($child->dateend()->toDate('Y'), $selectedYears)
        );
    }
    function normalizeTags($tags) {
        return array_map(fn($tag) => strtolower(Str::replace(trim($tag), ' ', '-')), $tags);
    }
    if ($typesParam = param('type')) {
    $selectedTypes = normalizeTags(explode('+', $typesParam));
    $events = $events->filter(fn($child) => 
        count(array_intersect($selectedTypes, normalizeTags($child->type()->split(',')))) > 0
        );
    }
    // Filter by series - match all selected series strictly with normalization
    if ($seriesParam = param('series')) {
        $selectedSeries = normalizeTags(explode('+', $seriesParam));
        $events = $events->filter(fn($child) => 
            count(array_intersect($selectedSeries, normalizeTags($child->series()->split(',')))) > 0
        );
    }
    // Filter by subjects - match all selected subjects strictly with normalization
    if ($subjectsParam = param('subject')) {
        $selectedSubjects = normalizeTags(explode('+', $subjectsParam));
        $events = $events->filter(fn($child) => 
            count(array_intersect($selectedSubjects, normalizeTags($child->subject()->split(',')))) > 0
        );
    }
?>

<section class='content all-events'>
    <?php if($events->isEmpty()): ?>
        <h3 class='strong'>No events match the selected criteria in our archive.<br>Please try another query.</h3>
    <?php else: ?>
        <?php foreach($events as $event): ?>
                <a class='event' href='<?= $event -> url() ?>'>
                <span><?= A::first($event->type()->split()) ?></span>
                <svg class='icon' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 71.76 71.42" role="img" aria-label="background" aria-description='project background image'>
                        <path class="star-1" d="M39.81,0s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                        <?php if($event->images()->template('cover-icon')->isNotEmpty()): ?>
                        <mask id="svgmask">
                        <path class="star-2" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                        </mask>
                        <image xmlns:xlink="http://www.w3.org/1999/xlink" preserveAspectRatio="xMidYMid slice" xlink:href="<?= $event ->images() ->template('cover-icon') ->first() -> crop(250, 250, 72) -> url() ?>" mask="url(#svgmask)">
                            <desc><?= $event ->images() ->template('cover-icon') ->first() -> alt() ?></desc>
                        </image>
                        <path class="star-outline" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>

                        <?php else: ?>
                        <path class="star-2" d="M32.41,7.55s-.24,29.31-32.41,32.42c0,0,28.5-1.44,32.41,31.44,0,0-.18-28.27,31.95-31.93,0,0-30.67-1.07-31.95-31.93Z"/>
                        <?php endif ?>
                </svg>
                <h3 class='strong'><?= $event -> title()?></h3>
                </a> 
        <?php endforeach ?>
    <?php endif ?>
</section>
<section class='extra-info modal filters'>
    <?php 
        $selectedYears = param('year') ? explode('+', param('year')) : [];
        $selectedTypes = param('type') ? explode('+', param('type')) : [];
        $selectedSeries = param('series') ? explode('+', param('series')) : [];
        $selectedSubjects = param('subject') ? explode('+', param('subject')) : [];

        // $typetags = $events -> pluck('type', ',', true);
        $typetags = array_map('strval', $events->pluck('type', ',', true));
        $seriestags = $events -> pluck('series', ',', true);
        $subjecttags = $events -> pluck('subject', ',', true);
        natcasesort($typetags);
        natcasesort($seriestags);
        natcasesort($subjecttags);
    ?>
    <table class='filters'>
        <tr>
            <th>Year:</th>
            <td>
                <span class='year tag all <?php e(!param('year'), 'active')?>' data-value=''>all</span>
                    <?php 
                        $startdates = $events -> pluck('datestart', ' ', true);
                        // $startdates = $kirby -> collection('all-events') -> pluck('datestart', ' ', true);
                        $enddates = $events -> pluck('dateend', ' ', true);
                        // $enddates = $kirby -> collection('all-events') -> pluck('dateend', ' ', true);
                        $alldates = array_merge($startdates, $enddates);
                        $years = array_unique(array_map(function($item){
                            return date('Y', strtotime($item));
                        }, $alldates));
                        rsort($years);
                    ?>
                    <?php foreach($years as $tag): ?>
                    <span class='year tag <?php e(in_array(Str::replace($tag, ' ', '-'), $selectedYears), 'active')?>' 
                        data-value='year:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                    <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <th>Type:</th>
            <td>
                <span class='type tag all <?php e(!param('type'), 'active')?>' data-value=''>all</span>
                <?php foreach($typetags as $tag): ?>
                    <span class='type tag <?php e(in_array(Str::replace($tag, ' ', '-'), $selectedTypes), 'active')?>' 
                        data-value='type:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
         <tr>
            <th>Series:</th>
            <td>
                <span class='series tag all <?php e(!param('series'), 'active')?>' data-value=''>all</span>
                <?php foreach($seriestags as $tag): ?>
                    <span class='series tag <?php e(in_array(Str::replace($tag, ' ', '-'), $selectedSeries), 'active')?>' 
                        data-value='series:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
        <tr>
            <th>Subject(s):</th>
            <td>
                <span class='subject tag all <?php e(!param('subject'), 'active')?>' data-value=''>all</span>
                <?php foreach($subjecttags as $tag): ?>
                    <span class='subject tag <?php e(in_array(Str::replace($tag, ' ', '-'), $selectedSubjects), 'active')?>' 
                        data-value='subject:<?= Str::replace($tag,' ','-') ?>'>
                        <?= strtolower(html($tag))?></span>
                <?php endforeach ?>
            </td>
        </tr>
    </table>
    <div class="button-cont">
        <button class='clear'><h2>Clear All</h2></button>
        <button class='apply'><h2>Apply</h2></button>
    </div>
</section>