<?php

return function ($site) {
    $subjects = $site->index()->pluck('subject', ',', true);

    $filteredSubjects = array_filter($subjects, function ($subject) use ($site) {
        return $site->index()->filterBy('subject', '*=', $subject)->count() > 0;
    });

    natcasesort($subjects); // Natural case-insensitive sorting
    return array_values($subjects); // Ensure it's a proper indexed array
};