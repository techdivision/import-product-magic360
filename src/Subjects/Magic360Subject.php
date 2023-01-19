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

use TechDivision\Import\Utils\RegistryKeys;
use TechDivision\Import\Utils\FileUploadConfigurationKeys;
use TechDivision\Import\Subjects\FileUploadTrait;
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
     * The name of the craeted image.
     *
     * @var integer
     */
    protected $parentImage;

    /**
     * Initializes the subject data
     *
     * @param string $serial The serial of the actual import
     *
     * @return void
     */
    public function setUp($serial)
    {

        // invoke the parent method
        parent::setUp($serial);

        // load the entity manager and the registry processor
        $registryProcessor = $this->getRegistryProcessor();

        // load the status of the actual import process
        $status = $registryProcessor->getAttribute($serial);

        // load the SKU => entity ID mapping
        $this->skuEntityIdMapping = $status[RegistryKeys::SKU_ENTITY_ID_MAPPING];

        // initialize the flag to decide copy images or not
        $this->setCopyImages($this->getConfiguration()->getParam(FileUploadConfigurationKeys::COPY_IMAGES));

        // initialize media directory => can be absolute or relative
        if ($this->getConfiguration()->hasParam(FileUploadConfigurationKeys::MEDIA_DIRECTORY)) {
            try {
                $this->setMediaDir($this->resolvePath($this->getConfiguration()->getParam(FileUploadConfigurationKeys::MEDIA_DIRECTORY)));
            } catch (\InvalidArgumentException $iae) {
                $this->getSystemLogger()->debug($iae->getMessage());
            }
        }

        // initialize images directory => can be absolute or relative
        if ($this->getConfiguration()->hasParam(FileUploadConfigurationKeys::IMAGES_FILE_DIRECTORY)) {
            try {
                $this->setImagesFileDir($this->resolvePath($this->getConfiguration()->getParam(FileUploadConfigurationKeys::IMAGES_FILE_DIRECTORY)));
            } catch (\InvalidArgumentException $iae) {
                $this->getSystemLogger()->debug($iae->getMessage());
            }
        }
    }

    /**
     * Set's the name of the created image.
     *
     * @param string $parentImage The name of the created image
     *
     * @return void
     */
    public function setParentImage($parentImage)
    {
        $this->parentImage = $parentImage;
    }

    /**
     * Return's the name of the created image.
     *
     * @return string The name of the created image
     */
    public function getParentImage()
    {
        return $this->parentImage;
    }
}
