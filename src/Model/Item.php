<?php

/**
 * FAQ model
 *
 * @package     Nails
 * @subpackage  module-faq
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Faq\Model;

use Nails\Common\Model\Base;
use Nails\Common\Traits\Model\Sortable;
use Nails\Faq\Constants;

/**
 * Class Item
 *
 * @package Nails\Faq\Model
 */
class Item extends Base
{
    use Sortable;

    // --------------------------------------------------------------------------

    /**
     * The table this model represents
     *
     * @var string
     */
    const TABLE = NAILS_DB_PREFIX . 'faq_item';

    /**
     * Whether to automatically set slugs or not
     *
     * @var bool
     */
    const AUTO_SET_SLUG = true;

    /**
     * The name of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_NAME = 'Group';

    /**
     * The provider of the resource to use (as passed to \Nails\Factory::resource())
     *
     * @var string
     */
    const RESOURCE_PROVIDER = Constants::MODULE_SLUG;

    // --------------------------------------------------------------------------

    /**
     * Item constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this
            ->addExpandableField([
                'trigger'   => 'group',
                'model'     => 'Group',
                'provider'  => Constants::MODULE_SLUG,
                'id_column' => 'group_id',
            ]);
    }

    // --------------------------------------------------------------------------

    /**
     * Returns the searchable columns for this module
     *
     * @return string[]
     */
    public function getSearchableColumns(): array
    {
        return [
            'id',
            'label',
            'body',
        ];
    }

    // --------------------------------------------------------------------------

    /**
     * Describes the fields for this model
     *
     * @param string $sTable The database table to query
     *
     * @return array
     */
    public function describeFields($sTable = null)
    {
        $aData = parent::describeFields($sTable);

        $aData['label']->validation[] = 'required';
        $aData['body']->validation[]  = 'required';
        $aData['body']->type          = 'wysiwyg';
        $aData['group_id']->label     = 'Group';
        $aData['group_id']->class     = 'js-searcher';
        $aData['group_id']->data      = ['api' => 'faq/group', 'min-length' => 0];

        return $aData;
    }
}
