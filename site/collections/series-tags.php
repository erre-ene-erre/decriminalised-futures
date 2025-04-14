<?php

return function ($site) {
    $series = $site->index()->pluck('series', ',', true);
    $normalizedSeries = array_map('mb_strtolower', $series);
    $uniqueSeries = array_unique($normalizedSeries);

    $usedSeries = [];
    foreach ($uniqueSeries as $serie) {
        foreach ($site->index() as $page) {
            $pageTags = array_map('mb_strtolower', $page->series()->split(','));
            if (in_array($serie, $pageTags)) {
                $usedSeries[] = $serie;
                break;
            }
        }
    }
    natcasesort($usedSeries);
    return array_values($usedSeries);
};

