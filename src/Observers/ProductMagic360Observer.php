<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\ProductMagic360Observer
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
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Magic360\Observers;

use TechDivision\Import\Product\Magic360\Utils\ColumnKeys;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Prepares the artefacts for the generic Magic360 gallery type import.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-link
 * @link      http://www.techdivision.com
 */
class ProductMagic360Observer extends AbstractProductImportObserver
{

    // ,is_360=J,images_360=372420/360/,

    /**
     * The artefact type.
     *
     * @var string
     */
    const ARTEFACT_TYPE = 'magic360';

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     */
    protected function process()
    {
        // we will only look for the image path if the row is flagged as having 360 images
        $is360 = $this->hasValue(ColumnKeys::IS_360);
        if ($is360) {
            $images360Path = $this->getValue(ColumnKeys::IMAGES_360);
            $artefact = array(
                ColumnKeys::IMAGES_360 => $images360Path,
                ColumnKeys::SKU => $this->getValue(ColumnKeys::SKU)
            );

            // finally adding the artefacts
            $this->addArtefacts(array($artefact));
        }
    }

    /**
     * Add the passed product type artefacts to the product with the
     * last entity ID.
     *
     * @param array $artefacts The product type artefacts
     *
     * @return void
     * @uses \TechDivision\Import\Product\Media\Subjects\MediaSubject::getLastEntityId()
     */
    protected function addArtefacts(array $artefacts)
    {
        $this->getSubject()->addArtefacts(ProductMagic360Observer::ARTEFACT_TYPE, $artefacts);
    }
}
