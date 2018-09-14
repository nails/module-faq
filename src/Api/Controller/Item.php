<?php

namespace Nails\Faq\Api\Controller;

use Nails\Api\Controller\CrudController;

class Item extends CrudController
{
    const CONFIG_MODEL_NAME     = 'Item';
    const CONFIG_MODEL_PROVIDER = 'nails/module-faq';
}
