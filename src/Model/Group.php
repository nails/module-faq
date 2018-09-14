<?php

/**
 * Group model
 *
 * @package     Nails
 * @subpackage  module-faq
 * @category    Model
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Faq\Model;

use Nails\Common\Model\Base;

class Group extends Base
{
    /**
     * Group constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table = NAILS_DB_PREFIX . 'faq_group';
        $this->addExpandableField([
            'trigger'   => 'items',
            'type'      => self::EXPANDABLE_TYPE_MANY,
            'property'  => 'items',
            'model'     => 'Item',
            'provider'  => 'nails/module-faq',
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

        return $aData;
    }
}
