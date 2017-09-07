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
use TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Adds the count of the images from within artefacts to the Magic360 tables
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class Magic360ColumnsObserver extends AbstractProductImportObserver
{

    /**
     * The product magic360 processor instance.
     *
     * @var \TechDivision\Import\Product\Services\ProductBunchProcessorInterface
     */
    protected $productMagic360Processor;

    /**
     * Initialize the observer with the passed product magic360 processor instance.
     *
     * @param \TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface $productMagic360Processor The product magic360 processor instance
     */
    public function __construct(ProductMagic360ProcessorInterface $productMagic360Processor)
    {
        $this->productMagic360Processor = $productMagic360Processor;
    }

    /**
     * Return's the product magic360 processor instance.
     *
     * @return \TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface The product magic360 processor instance
     */
    protected function getProductMagic360Processor()
    {
        return $this->productMagic360Processor;
    }

    /**
     * Process the observer's business logic.
     *
     * @return array The processed row
     *
     * @throws \Exception Possible error in non-debug mode
     */
    protected function process()
    {

        // extract the parent/child ID as well as the link type code from the row
        $sku = $this->getValue(ColumnKeys::SKU);

        // load parent product ID
        $productId = $this->getSubject()->mapSkuToEntityId($sku);

        // initialize the directories with the images to import
        $mediaDir = $this->getSubject()->getMediaDir();
        $images360Path = DIRECTORY_SEPARATOR . ltrim($this->getValue(ColumnKeys::IMAGES_PATH), DIRECTORY_SEPARATOR);

        // log a message with the folder name containing the images
        $this->getSubject()->getSystemLogger()->debug(sprintf('Now try to load 360° images from directory %s%s', $mediaDir, $images360Path));

        // iterate the images (if any) and initialize an entity for each one
        $images = $this->getSubject()->getFilesystemAdapter()->listContents($mediaDir . $images360Path);

        // query whether or not images are available
        if (count($images) > 0) {
            // initialize the entity
            $entity = $this->initializeMagic360Columns(
                $this->initializeEntity(
                    array(
                        MemberNames::PRODUCT_ID => $productId,
                        MemberNames::COLUMNS    => $imageSize = count($images)
                    )
                )
            );

            // persist the entity
            $this->persistMagic360Columns($entity);

            // log a debug message with the number of imported images
            $this->getSubject()->getSystemLogger()->debug(sprintf('Successfully updated column number to %d for product %d', $imageSize, $productId));
        }
    }

    /**
     * Initialize the magic360 column with the passed attributes and returns an instance.
     *
     * @param array $attr The product media gallery attributes
     *
     * @return array The initialized product media gallery
     */
    protected function initializeMagic360Columns(array $attr)
    {
        return $attr;
    }

    /**
     * Persists the column data and returns the ID.
     *
     * @param array $magic360Columns The product media gallery data to persist
     *
     * @return string The ID of the persisted entity
     */
    protected function persistMagic360Columns($magic360Columns)
    {
        return $this->getProductMagic360Processor()->persistMagic360Columns($magic360Columns);
    }
}
