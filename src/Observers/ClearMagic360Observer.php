<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\ClearMagic360Observer
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
use TechDivision\Import\Product\Magic360\Utils\SqlStatementKeys;
use TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface;
use TechDivision\Import\Product\Observers\AbstractProductImportObserver;

/**
 * Observer that removes the product with the SKU found in the CSV file.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class ClearMagic360Observer extends AbstractProductImportObserver
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
     */
    protected function process()
    {

        // query whether or not, we've found a new SKU => means we've found a new product
        if ($this->isLastSku($sku = $this->getValue(ColumnKeys::SKU))) {
            return;
        }

        // load the subject
        $subject = $this->getSubject();

        try {
            // get the mapping to product ID based on the preload entity IDs
            $productId = $subject->mapSkuToPreloadEntityId($sku);

            // FIRST delete the data related with the product with the passed SKU
            $this->deleteMagic360Gallery(array(ColumnKeys::PRODUCT_ID => $productId), SqlStatementKeys::DELETE_MAGIC360_GALLERY);
            $this->deleteMagic360Columns(array(ColumnKeys::PRODUCT_ID => $productId), SqlStatementKeys::DELETE_MAGIC360_COLUMNS);
        } catch (\Exception $e) {
            // query whether or not debug mode has been enabled
            if ($subject->isDebugMode()) {
                $subject->getSystemLogger()->warning($subject->appendExceptionSuffix($e->getMessage()));
            } else {
                throw $e;
            }
        }
    }

    /**
     * Deletes the gallery entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Gallery($row, $name = null)
    {
        $this->getProductMagic360Processor()->deleteMagic360Gallery($row, $name);
    }

    /**
     * Deletes the column entity with the passed attributes.
     *
     * @param array       $row  The attributes of the entity to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Columns($row, $name = null)
    {
        $this->getProductMagic360Processor()->deleteMagic360Columns($row, $name);
    }
}
