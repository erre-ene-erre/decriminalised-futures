<?php snippet('header') ?>

<section id='info-modal'>
    <div class='info-content text'>
         <?php
            $content = $page->info()->kt(); 
            $processedContent = preg_replace('/<code>(.*?)<\/code>/s', '$1', $content);
            echo html_entity_decode($processedContent);
        ?>
    </div>
</section>

<?php snippet('archive-content') ?>

<?php snippet('footer') ?>