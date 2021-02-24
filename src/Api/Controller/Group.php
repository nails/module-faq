<?php

namespace Nails\Faq\Api\Controller;

use Nails\Api\Controller\CrudController;
use Nails\Faq\Constants;

class Group extends CrudController
{
    const CONFIG_MODEL_NAME     = 'Group';
    const CONFIG_MODEL_PROVIDER = Constants::MODULE_SLUG;
}
