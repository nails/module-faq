<?php

/**
 * Migration:   2
 * Started:     10/08/2018
 * Finalised:   10/08/2018
 */

namespace Nails\Database\Migration\Nails\ModuleFaq;

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
        $this->query("RENAME TABLE `{{NAILS_DB_PREFIX}}faq` TO `{{NAILS_DB_PREFIX}}faq_item`;");
        $this->query("INSERT INTO `{{NAILS_DB_PREFIX}}faq_group` (`label`, `created`, `modified`) SELECT DISTINCT(`group`) `label`, NOW() `created`, NOW() `modified` FROM `{{NAILS_DB_PREFIX}}faq_item`;");
        $this->query("UPDATE `{{NAILS_DB_PREFIX}}faq_item` `item` SET `item`.`group` = (SELECT `group`.`id` FROM `{{NAILS_DB_PREFIX}}faq_group` `group` WHERE `group`.`label` = `item`.`group`);");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}faq_item` CHANGE `group` `group_id` INT(11)  UNSIGNED  NULL;");
        $this->query("ALTER TABLE `{{NAILS_DB_PREFIX}}faq_item` ADD FOREIGN KEY (`group_id`) REFERENCES `{{NAILS_DB_PREFIX}}faq_group` (`id`) ON DELETE SET NULL;");
    }
}
