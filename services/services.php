<?php

return [
    'models' => [
        'Item'   => function () {
            if (class_exists('\App\Faq\Model\Item')) {
                return new \App\Faq\Model\Item();
            } else {
                return new \Nails\Faq\Model\Item();
            }
        },
        'Group' => function () {
            if (class_exists('\App\Faq\Model\Group')) {
                return new \App\Faq\Model\Group();
            } else {
                return new \Nails\Faq\Model\Group();
            }
        },
    ],
];
