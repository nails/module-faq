<?php

namespace Nails\Faq\Api\Controller;

use Nails\Api\Controller\CrudController;
use Nails\Faq\Constants;

class Item extends CrudController
{
    const CONFIG_MODEL_NAME     = 'Item';
    const CONFIG_MODEL_PROVIDER = Constants::MODULE_SLUG;
}
