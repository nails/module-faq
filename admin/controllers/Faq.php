<?php

/**
 * Manage FAQs
 *
 * @package     Nails
 * @subpackage  module-faq
 * @category    Controller
 * @author      Nails Dev Team
 */

namespace Nails\Admin\Faq;

use Nails\Admin\Controller\DefaultController;

class Faq extends DefaultController
{
    const CONFIG_MODEL_NAME     = 'Faq';
    const CONFIG_MODEL_PROVIDER = 'nailsapp/module-faq';
    const CONFIG_SIDEBAR_GROUP  = 'FAQs';
    const CONFIG_SIDEBAR_ICON   = 'fa-question-circle';
    const CONFIG_TITLE_SINGLE   = 'FAQ';
    const CONFIG_TITLE_PLURAL   = 'FAQs';

    // --------------------------------------------------------------------------

    /**
     * Extract data from post variable
     * @return array
     */
    protected function getPostObject()
    {
        $aData              = parent::getPostObject();
        $aData['order']     = (int) getFromArray('order', $aData);
        $aData['is_active'] = (bool) getFromArray('is_active', $aData);
        return $aData;
    }
}
