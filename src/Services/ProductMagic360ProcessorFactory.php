<?php

/**
 * TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorFactory
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
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-cli-simple
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Magic360\Services;

use TechDivision\Import\Configuration\ProcessorConfigurationInterface;
use TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction;
use TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360ColumnsCreateProcessor;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360ColumnsDeleteProcessor;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360ColumnsUpdateProcessor;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360GalleryCreateProcessor;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360GalleryDeleteProcessor;
use TechDivision\Import\Product\Magic360\Actions\Processors\Magic360GalleryUpdateProcessor;
use TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository;
use TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository;

/**
 * Factory to create a new product media processor.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @copyright 2016 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-cli-simple
 * @link      http://www.techdivision.com
 */
class ProductMagic360ProcessorFactory
{

    /**
     * Returns the processor class name.
     *
     * @return string The processor class name
     */
    protected static function getProcessorType()
    {
        return 'TechDivision\Import\Product\Magic360\Services\ProductMagic360Processor';
    }

    /**
     * Factory method to create a new product media processor instance.
     *
     * @param \PDO                                                               $connection    The PDO connection to use
     * @param \TechDivision\Import\Configuration\ProcessorConfigurationInterface $configuration The subject configuration
     *
     * @return \TechDivision\Import\Product\Magic360\Services\ProductMagic360Processor The processor instance
     */
    public static function factory(\PDO $connection, ProcessorConfigurationInterface $configuration)
    {

        // load the utility class name
        $utilityClassName = $configuration->getUtilityClassName();

        // initialize the repository that provides product media gallery query functionality
        $productMagic360GalleryRepository = new ProductMagic360GalleryRepository();
        $productMagic360GalleryRepository->setUtilityClassName($utilityClassName);
        $productMagic360GalleryRepository->setConnection($connection);
        $productMagic360GalleryRepository->init();

        // initialize the repository that provides product media gallery value to entity query functionality
        $productMagic360ColumnsRepository = new ProductMagic360ColumnsRepository();
        $productMagic360ColumnsRepository->setUtilityClassName($utilityClassName);
        $productMagic360ColumnsRepository->setConnection($connection);
        $productMagic360ColumnsRepository->init();

        // initialize the action that provides product media gallery CRUD functionality
        $productMagic360GalleryCreateProcessor = new Magic360GalleryCreateProcessor();
        $productMagic360GalleryCreateProcessor->setUtilityClassName($utilityClassName);
        $productMagic360GalleryCreateProcessor->setConnection($connection);
        $productMagic360GalleryCreateProcessor->init();
        $productMagic360GalleryUpdateProcessor = new Magic360GalleryUpdateProcessor();
        $productMagic360GalleryUpdateProcessor->setUtilityClassName($utilityClassName);
        $productMagic360GalleryUpdateProcessor->setConnection($connection);
        $productMagic360GalleryUpdateProcessor->init();
        $productMagic360GalleryDeleteProcessor = new Magic360GalleryDeleteProcessor();
        $productMagic360GalleryDeleteProcessor->setUtilityClassName($utilityClassName);
        $productMagic360GalleryDeleteProcessor->setConnection($connection);
        $productMagic360GalleryDeleteProcessor->init();
        $magic360GalleryAction = new Magic360GalleryAction();
        $magic360GalleryAction->setCreateProcessor($productMagic360GalleryCreateProcessor);
        $magic360GalleryAction->setUpdateProcessor($productMagic360GalleryUpdateProcessor);
        $magic360GalleryAction->setDeleteProcessor($productMagic360GalleryDeleteProcessor);

        // initialize the action that provides product media gallery value CRUD functionality
        $productMagic360ColumnsCreateProcessor = new Magic360ColumnsCreateProcessor();
        $productMagic360ColumnsCreateProcessor->setUtilityClassName($utilityClassName);
        $productMagic360ColumnsCreateProcessor->setConnection($connection);
        $productMagic360ColumnsCreateProcessor->init();
        $productMagic360ColumnsUpdateProcessor = new Magic360ColumnsUpdateProcessor();
        $productMagic360ColumnsUpdateProcessor->setUtilityClassName($utilityClassName);
        $productMagic360ColumnsUpdateProcessor->setConnection($connection);
        $productMagic360ColumnsUpdateProcessor->init();
        $productMagic360ColumnsDeleteProcessor = new Magic360ColumnsDeleteProcessor()   ;
        $productMagic360ColumnsDeleteProcessor->setUtilityClassName($utilityClassName);
        $productMagic360ColumnsDeleteProcessor->setConnection($connection);
        $productMagic360ColumnsDeleteProcessor->init();
        $magic360ColumnsAction = new Magic360ColumnsAction();
        $magic360ColumnsAction->setCreateProcessor($productMagic360ColumnsCreateProcessor);
        $magic360ColumnsAction->setUpdateProcessor($productMagic360ColumnsUpdateProcessor);
        $magic360ColumnsAction->setDeleteProcessor($productMagic360ColumnsDeleteProcessor);

        // initialize the product media processor
        $processorType = static::getProcessorType();
        /** @var \TechDivision\Import\Product\Magic360\Services\ProductMagic360Processor $productMagic360Processor */
        $productMagic360Processor = new $processorType();
        $productMagic360Processor->setConnection($connection);
        $productMagic360Processor->setProductMagic360GalleryRepository($productMagic360GalleryRepository);
        $productMagic360Processor->setProductMagic360ColumnsRepository($productMagic360ColumnsRepository);
        $productMagic360Processor->setMagic360GalleryAction($magic360GalleryAction);
        $productMagic360Processor->setMagic360ColumnsAction($magic360ColumnsAction);

        // return the instance
        return $productMagic360Processor;
    }
}
