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

class Item extends Base
{
    use Sortable;

    // --------------------------------------------------------------------------

    /**
     * Faq constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table              = NAILS_DB_PREFIX . 'faq_item';
        $this->searchableFields[] = 'body';
        $this->addExpandableField([
            'trigger'   => 'group',
            'type'      => self::EXPANDABLE_TYPE_SINGLE,
            'property'  => 'group',
            'model'     => 'Group',
            'provider'  => 'nailsapp/module-faq',
            'id_column' => 'group_id',
        ]);
    }

    // --------------------------------------------------------------------------

    /**
     * Describes the fields for this model
     *
     * @param  string $sTable The database table to query
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
        $aData['group_id']->data      = ['api' => 'faq/group'];

        return $aData;
    }
}
