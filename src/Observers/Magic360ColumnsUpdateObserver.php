<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\Magic360ColumnsUpdateObserver
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

namespace TechDivision\Import\Product\Magic360\Observers;

use TechDivision\Import\Product\Magic360\Utils\MemberNames;

/**
 * Observer that creates/updates the magic360 columns information.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class Magic360ColumnsUpdateObserver extends Magic360ColumnsObserver
{

    /**
     * Initialize the magic360 column with the passed attributes and returns an instance.
     *
     * @param array $attr The product media gallery value attributes
     *
     * @return array The initialized product media gallery value
     */
    protected function initializeMagic360Columns(array $attr)
    {
        // query whether the product media gallery value already exists or not
        if ($entity = $this->getSubject()->loadMagic360Columns($attr[MemberNames::PRODUCT_ID])) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }
}
