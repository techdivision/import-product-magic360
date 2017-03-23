<?php

/**
 * TechDivision\Import\Product\Magic360\Subjects\Magic360Subject
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

namespace TechDivision\Import\Product\Magic360\Subjects;

use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use TechDivision\Import\Subjects\FileUploadTrait;
use TechDivision\Import\Utils\ConfigurationKeys;
use TechDivision\Import\Utils\FileUploadConfigurationKeys;
use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Product\Utils\RegistryKeys as ProductRegistryKeys;
use TechDivision\Import\Product\Subjects\AbstractProductSubject;

/**
 * The main Magic360 subject
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 *
 * @method \TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface getProductProcessor()
 */
class Magic360Subject extends AbstractProductSubject
{

    /**
     * The trait that provides file upload functionality.
     *
     * @var \TechDivision\Import\Subjects\FileUploadTrait
     */
    use FileUploadTrait;

    /**
     * The mapping for the SKUs to the created entity IDs.
     *
     * @var array $skuEntityIdMapping
     */
    protected $skuEntityIdMapping = array();

    /**
     * The entity IDs which were initially within the data storage, before other observers influenced them
     *
     * @var array $preloadEntityIds
     */
    protected $preloadEntityIds = array();

    /**
     * Initializes the subject data
     *
     * @return void
     * @see \Importer\Csv\Actions\ProductImportAction::prepare()
     */
    public function setUp()
    {

        // invoke the parent method
        parent::setUp();

        // load the entity manager and the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // load the status of the actual import process
        $status = $registryProcessor->getAttribute($this->serial);

        // load the attribute set we've prepared initially
        $this->skuEntityIdMapping = $status[RegistryKeys::SKU_ENTITY_ID_MAPPING];
        $this->preloadEntityIds = $status[ProductRegistryKeys::PRE_LOADED_ENTITY_IDS];

        // initialize the flag to decide copy images or not
        $this->setCopyImages($this->getConfiguration()->getParam(FileUploadConfigurationKeys::COPY_IMAGES));

        // initialize the filesystems root directory
        $this->setRootDir($this->getConfiguration()->getParam(ConfigurationKeys::ROOT_DIRECTORY, getcwd()));

        // initialize the filesystem
        $this->setFilesystem(new Filesystem(new Local($this->getRootDir())));

        // initialize media directory => can be absolute or relative
        if ($this->getConfiguration()->hasParam(FileUploadConfigurationKeys::MEDIA_DIRECTORY)) {
            $this->setMediaDir(
                $this->resolvePath(
                    $this->getConfiguration()->getParam(FileUploadConfigurationKeys::MEDIA_DIRECTORY)
                )
            );
        }

        // initialize images directory => can be absolute or relative
        if ($this->getConfiguration()->hasParam(FileUploadConfigurationKeys::IMAGES_FILE_DIRECTORY)) {
            $this->setImagesFileDir(
                $this->resolvePath(
                    $this->getConfiguration()->getParam(FileUploadConfigurationKeys::IMAGES_FILE_DIRECTORY)
                )
            );
        }
    }

    /**
     * Return the entity ID for the passed SKU.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \Exception Is thrown if the SKU is not mapped yet
     */
    public function mapSkuToEntityId($sku)
    {

        // query weather or not the SKU has been mapped
        if (isset($this->skuEntityIdMapping[$sku])) {
            return $this->skuEntityIdMapping[$sku];
        }

        // throw an exception if the SKU has not been mapped yet
        throw new \Exception(sprintf('Found not mapped SKU %s', $sku));
    }

    /**
     * Return the entity ID for the passed SKU based on the preload entity IDs.
     *
     * @param string $sku The SKU to return the entity ID for
     *
     * @return integer The mapped entity ID
     * @throws \Exception Is thrown if the SKU is not mapped yet
     */
    public function mapSkuToPreloadEntityId($sku)
    {

        // query weather or not the SKU has been mapped
        if (isset($this->preloadEntityIds[$sku])) {
            return $this->preloadEntityIds[$sku];
        }

        // throw an exception if the SKU has not been mapped yet
        throw new \Exception(sprintf('Found not mapped SKU %s within preload entities', $sku));
    }

    /**
     * Loads the magic360 gallery with the passed product ID.
     *
     * @param integer $productId The product ID of the gallery
     * @param integer $position  The position of the gallery entry
     *
     * @return array The bundle option
     */
    public function loadMagic360Gallery($productId, $position)
    {
        return $this->getProductProcessor()->loadMagic360Gallery($productId, $position);
    }

    /**
     * Loads the magic360 gallery with the passed name, store + parent ID.
     *
     * @param string $productId The product ID of the magic360 column to be returned
     *
     * @return array The bundle option
     */
    public function loadMagic360Columns($productId)
    {
        return $this->getProductProcessor()->loadMagic360Columns($productId);
    }

    /**
     * Persists the passed magic360 gallery and returns the ID.
     *
     * @param array $galleryEntity The magic360 gallery to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistMagic360Gallery($galleryEntity)
    {
        return $this->getProductProcessor()->persistMagic360Gallery($galleryEntity);
    }

    /**
     * Persists the passed magic360 gallery and returns the ID.
     *
     * @param array $columnsEntry The magic360 column to persist
     *
     * @return string The ID of the persisted entity
     */
    public function persistMagic360Columns($columnsEntry)
    {
        return $this->getProductProcessor()->persistMagic360Columns($columnsEntry);
    }

    /**
     * Persists the passed magic360 gallery and returns the ID.
     *
     * @param array       $row  The magic360 gallery data to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Gallery($row, $name = null)
    {
        $this->getProductProcessor()->deleteMagic360Gallery($row, $name);
    }

    /**
     * Persists the passed magic360 gallery and returns the ID.
     *
     * @param array       $row  The magic360 column data to delete
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Columns($row, $name = null)
    {
        $this->getProductProcessor()->deleteMagic360Columns($row, $name);
    }
}
