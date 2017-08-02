<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\Magic360GalleryUpdateObserver
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
 * Observer that creates/updates the magic360 gallery value information.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class Magic360GalleryUpdateObserver extends Magic360GalleryObserver
{

    /**
     * Initialize the gallery value with the passed attributes and returns an instance.
     *
     * @param array $attr The product media gallery value attributes
     *
     * @return array The initialized product media gallery value
     */
    protected function initializeMagic360Gallery(array $attr)
    {

        // load product ID and position
        $productId = $attr[MemberNames::PRODUCT_ID];
        $position = $attr[MemberNames::POSITION];

        // query whether the product media gallery value already exists or not
        if ($entity = $this->getProductMagic360Processor()->loadMagic360Gallery($productId, $position)) {
            return $this->mergeEntity($entity, $attr);
        }

        // simply return the attributes
        return $attr;
    }
}
