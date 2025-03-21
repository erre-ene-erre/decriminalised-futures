<?php

return function ($site) {
    $series = $site->index()->pluck('series', ',', true);

    $filteredSeries = array_filter($series, function ($serie) use ($site) {
        return $site->index()->filterBy('series', '*=', $serie)->count() > 0;
    });

    natcasesort($series); // Natural case-insensitive sorting
    return array_values($series); // Ensure it's a proper indexed array
};