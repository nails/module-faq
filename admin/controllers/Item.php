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
use Nails\Admin\Factory\IndexFilter;
use Nails\Common\Exception\FactoryException;
use Nails\Common\Exception\ModelException;
use Nails\Factory;

/**
 * Class Item
 *
 * @package Nails\Admin\Faq
 */
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
        'Label'       => 'label',
        'Active'      => 'is_active',
        'Group'       => 'group.label',
        'Created'     => 'created',
        'Modified'    => 'modified',
        'Modified By' => 'modified_by',
    ];
    const CONFIG_SORT_DATA      = ['expand' => ['group']];
    const CONFIG_SORT_COLUMNS   = [
        'Group' => 'group.label',
    ];

    // --------------------------------------------------------------------------

    /**
     * Extract data from post variable
     *
     * @return array
     */
    protected function getPostObject(): array
    {
        $aData              = parent::getPostObject();
        $aData['is_active'] = (bool) getFromArray('is_active', $aData);

        return $aData;
    }

    // --------------------------------------------------------------------------

    /**
     * @return array
     * @throws FactoryException
     * @throws ModelException
     */
    protected function indexDropdownFilters(): array
    {
        /** @var \Nails\Faq\Model\Group $oGroupModel */
        $oGroupModel = Factory::model('Group', 'nails/module-faq');
        /** @var \Nails\Faq\Resource\Group[] $aGroups */
        $aGroups  = $oGroupModel->getAll();
        $aFilters = parent::indexDropdownFilters();

        if (!empty($aGroups)) {

            /** @var IndexFilter $oFilter */
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

    // --------------------------------------------------------------------------

    /**
     * @return array
     * @throws FactoryException
     */
    protected function indexCheckboxFilters(): array
    {
        $aFilters = parent::indexCheckboxFilters();

        $aFilters[] = Factory::factory('IndexFilter', 'nails/module-admin')
            ->setLabel('Status')
            ->setColumn('is_active')
            ->addOption('Active', true, true)
            ->addOption('Inactive', false, true);

        return $aFilters;
    }
}
