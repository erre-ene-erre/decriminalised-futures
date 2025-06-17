<h1 class='event-title'>Search: "<?= $query ?>"</h1>

<?php if($results -> isNotEmpty()): ?>
<ul class='search-results'>
  <?php foreach ($results as $result): ?>


    <?php
        $rawContent = ($result->info()->value() ?? '') . '' .
                    ($result->highlight()->value() ?? '') . ' ' .
                    ($result->textcontent()->value() ?? '');
        $rawContent = preg_replace('/<code>&lt;.*?&gt;<\/code>/is', '', $rawContent);        $cleanContent = strip_tags($rawContent);
        $position = stripos($cleanContent, $query);

        $wordsRange = 4;
        if ($position !== false) {
            $words = preg_split('/\s+/', $cleanContent);
            $charactersUpToPosition = substr($cleanContent, 0, $position);
            // $wordIndex = str_word_count($charactersUpToPosition);
            $wordIndex = count(preg_split('/\s+/', $charactersUpToPosition));
            $startWordIndex = max(0, $wordIndex - $wordsRange);
            $endWordIndex = min(count($words) - 1, $wordIndex + $wordsRange);

            $snippetWords = array_slice($words, $startWordIndex, $endWordIndex - $startWordIndex + 1);
            $snippet = implode(' ', $snippetWords);
            $snippet = preg_replace('/(' . preg_quote($query, '/') . ')/i', '<strong>$1</strong>', $snippet);
        } else{
            $snippet = '';
        }
    ?>
  <li class='result'>
    <svg class='icon' xmlns="http://www.w3.org/2000/svg" viewBox="0 0 787.16 781.15" role="graphics-symbol" aria-hidden='true'>
        <path class="star" d="M396.38,0S393.39,358.5,0,396.57c0,0,348.62-17.61,396.38,384.58,0,0-2.22-345.81,390.78-390.57,0,0-375.1-13.06-390.78-390.58Z"/>
    </svg>
    <a href="<?= $result->url() ?>">
      <h2><?= $result->title() ?></h2>
    </a>
    <?php if($snippet): ?>
        <span class='snippet'><?= $snippet ?></span>
    <?php elseif($result -> template() =='media-file'): ?>
        <span>[image]</span>
    <?php endif ?>


  </li>
  <?php endforeach ?>
</ul>
<?php else:?>
  <h3 class='strong'>Your search returned no results. Go back to the <a href='<?= page('archive') -> url() ?>'>Archive</a></h3>
<?php endif ?>
</section>