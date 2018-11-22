<?php

namespace MetroUI_GET;

use MetroUI_GET\Service\Factory\MetroUIServicesFactory;
use MetroUI_GET\Service\MetroUIServices;

return [
    'gotParameters' => [
        'theme' => 'metroui'
    ],

    'service_manager' => [
        'factories' => [
            MetroUIServices::class => MetroUIServicesFactory::class,
        ],
    ],

    'view_manager' => [
        'template_map' => [
            'metroui/layout'           => __DIR__ . '/../view/metro-ui-get/layout/layout.twig',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];