<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow" />

    <?php if($page->isHomePage()): ?>
    <meta property="title" content="<?= $site->title() ?>">
    <meta property="og:title" content="<?= $site->title() ?>">
    <?php else: ?>
    <meta property="title" content="<?= $page->title() ?>  :  <?= $site->title() ?>">
    <meta property="og:title" content="<?= $page->title() ?>  :  <?= $site->title() ?>">
    <?php endif ?>

    <meta name="description" content="<?= $page->metadescription() -> or($site -> metadescription()) ?>">
    <meta property="og:description" content="<?= $page->metadescription() -> or($site -> metadescription()) ?>">
    <meta property="og:url" content="<?= $site -> url() ?>">

    <meta name="keywords" content="creative resistance, labour rights, advocacy, marginalised communities, decriminalisation">

    <script type="application/ld+json">
        <?= json_encode([
          "@context" => "https://schema.org",
          "@type" => "CreativeWork",
          "name" => "Decriminalised Futures",
          "description" => "A creative advocacy project by and for sex workers, using popular education and storytelling.",
          "keywords" => "decriminalisation, creative resistance, community education, sex worker rights",
          "creator" => [
            "@type" => "Organization",
            "name" => "Decriminalised Futures"
          ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
    
    <?php if($page->isHomePage()): ?>
    <title> <?= $site->title() ?></title>
    <?php else: ?>
    <title><?= $page->title() ?>  :  <?= $site->title() ?></title>
    <?php endif ?>
    <link rel="icon" type='image/png' href="/assets/logos/favicon.png">

    <?= css('/assets/css/index.css?v=1.3.3') ?>
</head>
<body>
    <main id='swup' class=' transition-fade main-container <?= str_replace(' ', '-', $page -> template()) ?>' >
    <?php if($page -> isHomePage()): ?>
    <?php else: ?>
        <?php snippet('header-menu') ?>
    <?php endif ?>
    <?php snippet('accessibility-menu') ?>
