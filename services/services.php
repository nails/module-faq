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
        'Item'  => function ($mObj): Resource\Item {
            if (class_exists('\App\Faq\Resource\Item')) {
                return new \App\Faq\Resource\Item($mObj);
            } else {
                return new Resource\Item($mObj);
            }
        },
        'Group' => function ($mObj): Resource\Group {
            if (class_exists('\App\Faq\Resource\Group')) {
                return new \App\Faq\Resource\Group($mObj);
            } else {
                return new Resource\Group($mObj);
            }
        },
    ],
];
