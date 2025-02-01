<?php

class EventPage extends Page
{
  public function children(): Kirby\Cms\Pages
  {
    $media = [];

    foreach ($this->files()->template('media-file') as $item) {
      $media[] = [
        'slug'     => $item->name(),
        'num'      => $item->sort()->value(),
        'template' => 'media-file',
        'model'    => 'media-file',
      ];
    }

    return Pages::factory($media, $this);
  }
}