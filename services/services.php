<?php

return array(
    'models' => array(
        'Faq' => function () {
            return new \Nails\Faq\Model\Faq();
            if (class_exists('\App\Faq\Model\Faq')) {
                return new \App\Faq\Model\Faq();
            } else {
                return new \Nails\Faq\Model\Faq();
            }
        }
    )
);
