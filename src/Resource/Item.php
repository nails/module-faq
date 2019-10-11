<?php

namespace Nails\Faq\Resource;

use Nails\Common\Resource\Entity;
use Nails\Faq\Resource;

/**
 * Class Item
 *
 * @package Nails\Faq\Resource
 *
 */
class Item extends Entity
{
    /**
     * The item's label
     *
     * @var string
     */
    public $label;

    /**
     * The item's slug
     *
     * @var string
     */
    public $slug;

    /**
     * The item's group ID
     *
     * @var int
     */
    public $group_id;

    /**
     * The item's group
     *
     * @var Group
     */
    public $group;

    /**
     * The item's body
     *
     * @var string
     */
    public $body;

    /**
     * The item's order
     *
     * @var int
     */
    public $order;

    /**
     * Whether the item is active
     *
     * @var bool
     */
    public $is_active;
}
