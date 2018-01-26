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
use Nails\Factory;

class Faq extends Base
{
    /**
     * Faq constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->table              = NAILS_DB_PREFIX . 'faq';
        $this->searchableFields[] = 'body';
    }

    // --------------------------------------------------------------------------

    /**
     * Describes the fields for this model
     *
     * @return array
     */
    public function describeFields()
    {
        $aData = parent::describeFields();

        $aData['label']->validation[] = 'required';
        $aData['body']->validation[]  = 'required';
        $aData['body']->type          = 'wysiwyg';

        return $aData;
    }

    // --------------------------------------------------------------------------

    /**
     * Returns an array of the groups used in the FAQs
     * @return array
     */
    public function getGroups()
    {
        $oDb = Factory::service('Database');
        $oDb->select('DISTINCT(`group`) `group`');
        $aGroups = $oDb->get($this->table)->result();
        $aOut    = ['No Group'];

        foreach ($aGroups as $group) {
            $aOut[] = $group->group ? $group->group : 'No Group';
        }

        return array_unique($aOut);
    }
}
