<?php

namespace Nails\Faq\Resource;

use Nails\Common\Resource\Entity;
use Nails\Common\Resource\ExpandableFieldData;
use Nails\Faq\Resource;

/**
 * Class Group
 *
 * @package Nails\Faq\Resource
 *
 */
class Group extends Entity
{
    /**
     * The group's label
     *
     * @var string
     */
    public $label;

    /**
     * The group's slug
     *
     * @var string
     */
    public $slug;

    /**
     * The FAQ items (expandable field)
     *
     * @var ExpandableFieldData
     */
    public $items;
}
