<?php 
return [
    'debug' => false,
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
    ],
    'routes' => [
      [
        'pattern' => 'sitemap.xml',
        'action'  => function () {
          // Load the sitemap page manually
          $page = page('sitemap');
          return $page->render([], ['contentType' => 'application/xml']);
        }
      ]
    ],
    'bnomei.securityheaders.setter' => function ($instance) {
        /** @var ParagonIE\CSPBuilder\CSPBuilder $csp */
        $csp = $instance->csp();

        // YouTube
        $csp->addSource('frame', 'https://www.youtube.com');
        $csp->addSource('frame', 'https://youtube.com');
        $csp->addSource('image', 'https://*.ytimg.com');
        $csp->addSource('script', 'https://*.youtube.com');

        // Vimeo
        $csp->addSource('frame', 'https://player.vimeo.com');
        $csp->addSource('script', 'https://f.vimeocdn.com');
        $csp->addSource('style', 'https://f.vimeocdn.com');
        $csp->addSource('image', 'https://i.vimeocdn.com');

        // Mailchimp forms (adjust these based on exact embed code)
        $csp->addSource('script', 'https://*.mailchimp.com');
        $csp->addSource('frame', 'https://*.mailchimp.com');
        $csp->addSource('connect', 'https://*.mailchimp.com');
        $csp->addSource('form-action', 'https://*.mailchimp.com');
        $csp->addSource('img', 'https://*.mailchimp.com');

        // Fonts
        $csp->addSource('font', 'https://fonts.gstatic.com');
        $csp->addSource('style', 'https://fonts.googleapis.com');

        // Unpkg
        $csp->addSource('script', 'https://unpkg.com');
    },
    'bnomei.securityheaders.headers' => [
    'Permissions-Policy' => "fullscreen=(self 'https://player.vimeo.com' 'https://www.youtube.com')"
    ]
];
?>