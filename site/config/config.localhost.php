<?php 
return [
    'debug' => true,
    'panel' => [
      'install' => true,
    ],
    'thumbs' => [
        'srcsets' => [
            'default' => [
                '300w'  => ['width' => 300, 'quality' => 80],
                '600w'  => ['width' => 600, 'quality' => 80],
                '900w'  => ['width' => 900, 'quality' => 80],
                '1200w' => ['width' => 1200, 'quality' => 80],
                '1800w' => ['width' => 1800, 'quality' => 80]
            ],
            'portrait' => [
                '300w'  => ['width' => 300, 'height' => 450, 'quality' => 80, 'crop' => 'center'],
                '600w'  => ['width' => 600, 'height' => 900, 'quality' => 80, 'crop' => 'center'],
                '900w'  => ['width' => 900, 'height' => 1350, 'quality' => 80, 'crop' => 'center'],
                '1200w' => ['width' => 1200, 'height' => 1800, 'quality' => 80, 'crop' => 'center'],
                '1800w' => ['width' => 1800, 'height' => 2700, 'quality' => 80, 'crop' => 'center']
            ],
            'landscape' => [
                '300w'  => ['width' => 450, 'height' => 300, 'quality' => 80, 'crop' => 'center'],
                '600w'  => ['width' => 900, 'height' => 600, 'quality' => 80, 'crop' => 'center'],
                '900w'  => ['width' => 1350, 'height' => 900, 'quality' => 80, 'crop' => 'center'],
                '1200w' => ['width' => 1800, 'height' => 1200, 'quality' => 80, 'crop' => 'center'],
                '1800w' => ['width' => 2700, 'height' => 1800, 'quality' => 80, 'crop' => 'center']
            ]
        ]
    ],
    'hooks' => [
        'file.create:after' => function (Kirby\Cms\File $file) {
            $name = $file->name();
            $newName = str_replace('.', '_', $name);
            $newFilename = $newName . '.' . $file->extension();
            if ($newFilename !== $file -> filename()) {
                $file->changeName($newName);
            }
        },
        'page.update:after' => function ($newPage, $oldPage) {
            $fields = ['subject', 'series', 'type']; // Add any tag fields you want to normalize

            $updates = [];

            foreach ($fields as $field) {
                if ($newPage->content()->get($field)->isNotEmpty()) {
                    // Split tags, lowercase, trim, remove duplicates
                    $normalized = array_unique(array_map(function ($tag) {
                        return mb_strtolower(trim($tag));
                    }, $newPage->content()->get($field)->split(',')));

                    // Recombine into comma-separated string
                    $updates[$field] = implode(', ', $normalized);
                }
            }

            if (!empty($updates)) {
                $newPage->update($updates);
            }
        }
    ]
];
?>