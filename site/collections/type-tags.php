<?php

return function ($site) {
    $types = $site->index()->pluck('type', ',', true);
    $normalizedTypes = array_map('mb_strtolower', $types);
    $uniqueTypes = array_unique($normalizedTypes);

    $usedTypes = [];
    foreach ($uniqueTypes as $type) {
        foreach ($site->index() as $page) {
            $pageTags = array_map('mb_strtolower', $page->type()->split(','));
            if (in_array($type, $pageTags)) {
                $usedTypes[] = $type;
                break;
            }
        }
    }
    natcasesort($usedTypes);
    return array_values($usedTypes);
};
