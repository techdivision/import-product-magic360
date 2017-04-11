<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\Magic360ImageObserver
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

use TechDivision\Import\Product\Magic360\Utils\ColumnKeys;
use TechDivision\Import\Product\Magic360\Utils\MemberNames;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Adds the images from within artefacts to the Magic360 tables
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class Magic360GalleryObserver extends AbstractProductImportObserver
{

    /**
     * Process the observer's business logic.
     *
     * @return void
     *
     * @throws \Exception Possible error in non-debug mode
     */
    protected function process()
    {
        // extract the parent/child ID as well as the link type code from the row
        $sku = $this->getValue(ColumnKeys::SKU);

        // load parent/child IDs and link type ID
        $productId = $this->getSubject()->mapSkuToEntityId($sku);

        $images360Path = DIRECTORY_SEPARATOR . ltrim($this->getValue(ColumnKeys::IMAGES_PATH), DIRECTORY_SEPARATOR);
        $mediaFilePath = $this->getSubject()->getMediaDir();
        // iterate the images (if any) and initialize an entity for each one
        $images = $this->getSubject()->getFilesystem()->listContents($mediaFilePath . $images360Path);
        if (count($images) > 0) {
            $entity = null;
            $entityId = null;
            /**
             * @var integer $position
             * @var array $image
             */
            foreach ($images as $position => $image) {
                $entity = $this->initializeMagic360Gallery($this->initializeEntity(
                    array(
                        MemberNames::PRODUCT_ID => $productId,
                        MemberNames::POSITION => $position + 1,
                        MemberNames::FILE => $images360Path . $image['basename']
                    )
                ));
                $this->persistMagic360Gallery($entity);
            }
        }
    }

    /**
     * Initialize the magic360 gallery with the passed attributes and returns an instance.
     *
     * @param array $attr The gallery attributes
     *
     * @return array The initialized gallery
     */
    protected function initializeMagic360Gallery(array $attr)
    {
        return $attr;
    }

    /**
     * Persists the passed magic360 gallery data and returns the ID.
     *
     * @param array $magic360Gallery The gallery data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistMagic360Gallery($magic360Gallery)
    {
        return $this->getSubject()->persistMagic360Gallery($magic360Gallery);
    }
}
