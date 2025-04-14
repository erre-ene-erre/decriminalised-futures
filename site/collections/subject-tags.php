<?php

return function ($site) {
    $subjects = $site->index()->pluck('subject', ',', true);
    $normalizedSubjects = array_map('mb_strtolower', $subjects);
    
    $uniqueSubjects = array_unique($normalizedSubjects);

$usedSubjects = [];
    foreach ($uniqueSubjects as $subject) {
        foreach ($site->index() as $page) {
            $pageTags = array_map('mb_strtolower', $page->subject()->split(','));
            if (in_array($subject, $pageTags)) {
                $usedSubjects[] = $subject;
                break;
            }
        }
    }
    natcasesort($usedSubjects);
    return array_values($usedSubjects);
};