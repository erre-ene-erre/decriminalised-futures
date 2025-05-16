<?php
header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <?php foreach ($site->pages()->index()->listed() as $page): ?>
    <url>
      <loc><?= html($page->url()) ?></loc>
      <lastmod><?= $page->modified('Y-m-d') ?></lastmod>
    </url>
  <?php endforeach ?>
</urlset>