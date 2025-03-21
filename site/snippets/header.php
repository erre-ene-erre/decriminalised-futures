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

    
    <?php if($page->isHomePage()): ?>
    <title> <?= $site->title() ?></title>
    <?php else: ?>
    <title><?= $page->title() ?>  :  <?= $site->title() ?></title>
    <?php endif ?>
    <link rel="icon" type='image/png' href="/assets/logos/favicon.png">

    <?= css('/assets/css/index.css?v=1.2.8') ?>
</head>
<body>
    <main id='swup' class=' transition-fade main-container <?= str_replace(' ', '-', $page -> template()) ?>' >
    <?php if($page -> isHomePage()): ?>
    <?php else: ?>
        <?php snippet('header-menu') ?>
    <?php endif ?>
    <?php snippet('accessibility-menu') ?>
