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
        $productMagic360GalleryRepository = new ProductMagic360GalleryRepository($connection, $utilityClassName);

        // initialize the repository that provides product media gallery value to entity query functionality
        $productMagic360ColumnsRepository = new ProductMagic360ColumnsRepository($connection, $utilityClassName);

        // initialize the action that provides product media gallery CRUD functionality
        $magic360GalleryAction = new Magic360GalleryAction(
            new Magic360GalleryCreateProcessor($connection, $utilityClassName),
            new Magic360GalleryUpdateProcessor($connection, $utilityClassName),
            new Magic360GalleryDeleteProcessor($connection, $utilityClassName)
        );

        // initialize the action that provides product media gallery value CRUD functionality
        $magic360ColumnsAction = new Magic360ColumnsAction(
            new Magic360ColumnsCreateProcessor($connection, $utilityClassName),
            new Magic360ColumnsUpdateProcessor($connection, $utilityClassName),
            new Magic360ColumnsDeleteProcessor($connection, $utilityClassName)
        );

        // initialize and return the product magic 360 processor
        $processorType = static::getProcessorType();
        /** @var \TechDivision\Import\Product\Magic360\Services\ProductMagic360Processor $productMagic360Processor */
        return new $processorType(
            $connection,
            $productMagic360GalleryRepository,
            $productMagic360ColumnsRepository,
            $magic360GalleryAction,
            $magic360ColumnsAction
        );
    }
}
