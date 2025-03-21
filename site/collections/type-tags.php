<?php

return function ($site) {
    $types = $site->index()->pluck('type', ',', true);

    $filteredTypes = array_filter($types, function ($type) use ($site) {
        return $site->index()->filterBy('type', '*=', $type)->count() > 0;
    });

    natcasesort($types); // Natural case-insensitive sorting
    return array_values($types); // Ensure it's a proper indexed array
};