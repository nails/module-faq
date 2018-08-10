<?php

/**
 * Migration:   2
 * Started:     10/08/2018
 * Finalised:   10/08/2018
 */

namespace Nails\Database\Migration\Nailsapp\ModuleFaq;

use Nails\Common\Console\Migrate\Base;

class Migration2 extends Base
{
    /**
     * Execute the migration
     * @return Void
     */
    public function execute()
    {
        $this->query("
            CREATE TABLE `{{NAILS_DB_PREFIX}}faq_group` (
                `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
                `label` varchar(150) DEFAULT NULL,
                `created` datetime NOT NULL,
                `created_by` int(11) unsigned DEFAULT NULL,
                `modified` datetime NOT NULL,
                `modified_by` int(11) unsigned DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `created_by` (`created_by`),
                KEY `modified_by` (`modified_by`),
                CONSTRAINT `{{NAILS_DB_PREFIX}}faq_group_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL,
                CONSTRAINT `{{NAILS_DB_PREFIX}}faq_group_ibfk_2` FOREIGN KEY (`modified_by`) REFERENCES `{{NAILS_DB_PREFIX}}user` (`id`) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        $this->query("RENAME TABLE `nails_faq` TO `nails_faq_item`;");
        //  Migrate to groups table
        $this-query("ALTER TABLE `nails_faq_item` CHANGE `group` `group_id` INT(11)  UNSIGNED  NULL;");
        $this-query("ALTER TABLE `nails_faq_item` ADD FOREIGN KEY (`group_id`) REFERENCES `nails_faq_group` (`id`) ON DELETE SET NULL;");
        //  Add associations
    }
}
