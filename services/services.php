<?php

use Nails\Faq\Model;
use Nails\Faq\Resource;

return [
    'models'    => [
        'Item'  => function (): Model\Item {
            if (class_exists('\App\Faq\Model\Item')) {
                return new \App\Faq\Model\Item();
            } else {
                return new Model\Item();
            }
        },
        'Group' => function (): Model\Group {
            if (class_exists('\App\Faq\Model\Group')) {
                return new \App\Faq\Model\Group();
            } else {
                return new Model\Group();
            }
        },
    ],
    'resources' => [
        'Item'  => function ($resource, $model): Resource\Item {
            if (class_exists('\App\Faq\Resource\Item')) {
                return new \App\Faq\Resource\Item($resource, $model);
            } else {
                return new Resource\Item($resource, $model);
            }
        },
        'Group' => function ($resource, $model): Resource\Group {
            if (class_exists('\App\Faq\Resource\Group')) {
                return new \App\Faq\Resource\Group($resource, $model);
            } else {
                return new Resource\Group($resource, $model);
            }
        },
    ],
];
