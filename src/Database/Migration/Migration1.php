<?php

/**
 * Migration:   1
 * Started:     26/01/2018
 * Finalised:   26/01/2018
 */

namespace Nails\Faq\Database\Migration;

use Nails\Common\Console\Migrate\Base;

class Migration1 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}faq` CHANGE `isActive` `is_active` TINYINT(1)  UNSIGNED  NOT NULL  DEFAULT '1';");
    }
}
