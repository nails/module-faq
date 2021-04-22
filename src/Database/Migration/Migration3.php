<?php

/**
 * Migration:   3
 * Started:     11/10/2019
 */

namespace Nails\Faq\Database\Migration;

use Exception;
use Nails\Common\Console\Migrate\Base;

class Migration3 extends Base
{
    /**
     * Execute the migration
     *
     * @return Void
     */
    public function execute()
    {
        $this->query('ALTER TABLE `{{NAILS_DB_PREFIX}}faq_group` ADD `order` INT(11) UNSIGNED NOT NULL DEFAULT 0 AFTER `label`;');

        foreach (['faq_group', 'faq_item'] as $sTable) {

            //  Add column
            $this->query('ALTER TABLE `{{NAILS_DB_PREFIX}}' . $sTable . '` ADD `slug` VARCHAR(150) NOT NULL DEFAULT \'\' AFTER `id`;');

            //  Populate slugs
            $oStatement = $this->query('SELECT id, label FROM `{{NAILS_DB_PREFIX}}' . $sTable . '`;');
            while ($oRow = $oStatement->fetch(\PDO::FETCH_OBJ)) {
                $this
                    ->prepare('UPDATE `{{NAILS_DB_PREFIX}}' . $sTable . '` SET `slug` = :slug WHERE `id` = :id')
                    ->execute([
                        ':slug' => strtolower(url_title($oRow->id . ' ' . $oRow->label)),
                        ':id'   => $oRow->id,
                    ]);
            }

            //  Add unique
            $this->query('ALTER TABLE `{{NAILS_DB_PREFIX}}' . $sTable . '` ADD UNIQUE INDEX (`slug`);');
        }
    }
}
