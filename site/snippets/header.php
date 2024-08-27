<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php if($page->isHomePage()): ?>
    <meta property="title" content="<?= $site->title() ?>">
    <meta property="og:title" content="<?= $site->title() ?>">
    <?php else: ?>
    <meta property="title" content="<?= $page->title() ?>  &#9650;  <?= $site->title() ?>">
    <meta property="og:title" content="<?= $page->title() ?>  &#9650;  <?= $site->title() ?>">
    <?php endif ?>

    <meta name="description" content="<?= $page->metadescription() -> or($site -> metadescription()) ?>">
    <meta property="og:description" content="<?= $page->metadescription() -> or($site -> metadescription()) ?>">
    <meta property="og:url" content="<?= $site -> url() ?>">

    
    <?php if($page->isHomePage()): ?>
    <title> <?= $site->title() ?></title>
    <?php else: ?>
    <title><?= $page->title() ?>  &#9650;  <?= $site->title() ?></title>
    <?php endif ?>
    <link rel="icon" type='image/png' href="/assets/logos/favicon.png">

    <?= css('/assets/css/index.css') ?>
</head>
<body>
    <?php snippet('header-menu') ?>
    <main class='main-container <?= str_replace(' ', '-', $page -> template()) ?>' >