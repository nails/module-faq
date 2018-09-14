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
use Nails\Factory;

class Item extends DefaultController
{
    const CONFIG_MODEL_NAME     = 'Item';
    const CONFIG_MODEL_PROVIDER = 'nails/module-faq';
    const CONFIG_SIDEBAR_GROUP  = 'FAQs';
    const CONFIG_SIDEBAR_ICON   = 'fa-question-circle';
    const CONFIG_TITLE_SINGLE   = 'FAQ';
    const CONFIG_TITLE_PLURAL   = 'FAQs';
    const CONFIG_INDEX_DATA     = ['expand' => ['group']];
    const CONFIG_INDEX_FIELDS   = [
        'label'       => 'Label',
        'group.label' => 'Group',
        'created'     => 'Created',
        'modified'    => 'Modified',
        'modified_by' => 'Modified By',
    ];

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

    // --------------------------------------------------------------------------

    protected function indexDropdownFilters()
    {
        $oGroupModel = Factory::model('Group', 'nails/module-faq');
        $aGroups     = $oGroupModel->getAll();
        $aFilters    = parent::indexDropdownFilters();

        if (!empty($aGroups)) {

            $oFilter = Factory::factory('IndexFilter', 'nails/module-admin')
                              ->setLabel('Group')
                              ->setColumn('group_id');

            $oFilter->addOption('All Groups');
            foreach ($aGroups as $oGroup) {
                $oFilter->addOption($oGroup->label, $oGroup->id);
            }
            $oFilter->addOption('No Group', '`group_id` IS NULL', false, true);

            $aFilters[] = $oFilter;
        }

        return $aFilters;
    }
}
