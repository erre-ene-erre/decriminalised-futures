<?php

class MediaFilePage extends Page
{
  public function image(string $filename = null): Kirby\Cms\File|null
  {
    if (!$filename) {
      return $this->parent()->files()->template('media-file')->findBy('name', $this->slug());
    }

    return parent::image($filename);
  }
}