<?php

/**
 * TechDivision\Import\Product\Magic360\Utils\MemberNames
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * PHP version 5
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Magic360\Utils;

use \TechDivision\Import\Product\Utils\MemberNames as FallbackMemberNames;

/**
 * Utility class containing the entities member names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class MemberNames extends FallbackMemberNames
{

    /**
     * Name for the member 'product_id'.
     *
     * @var integer
     */
    const PRODUCT_ID = 'product_id';

    /**
     * Name for the member 'position'.
     *
     * @var integer
     */
    const POSITION = 'position';

    /**
     * Name for the member 'file'.
     *
     * @var string
     */
    const FILE = 'file';

    /**
     * Name for the member 'columns'.
     *
     * @var string
     */
    const COLUMNS = 'columns';
}
