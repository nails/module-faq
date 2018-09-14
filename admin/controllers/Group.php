<?php

/**
 * Manage FAQ Groups
 *
 * @package     Nails
 * @subpackage  module-faq
 * @category    Controller
 * @author      Nails Dev Team
 */

namespace Nails\Admin\Faq;

use Nails\Admin\Controller\DefaultController;

class Group extends DefaultController
{
    const CONFIG_MODEL_NAME     = 'Group';
    const CONFIG_MODEL_PROVIDER = 'nails/module-faq';
    const CONFIG_SIDEBAR_GROUP  = 'FAQs';
    const CONFIG_SIDEBAR_ICON   = 'fa-question-circle';
}
