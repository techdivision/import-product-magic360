<?php

/**
 * TechDivision\Import\Product\Magic360\Services\ProductMagic360ProcessorInterface
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

namespace TechDivision\Import\Product\Magic360\Services;

use TechDivision\Import\Product\Services\ProductProcessorInterface;

/**
 * A SLSB providing methods to load product data using a PDO connection.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
interface ProductMagic360ProcessorInterface extends ProductProcessorInterface
{

    /**
     * Sets the repository to load magic360 gallery data.
     *
     * @param \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository $productMagic360GalleryRepository The repository instance
     *
     * @return void
     */
    public function setProductMagic360GalleryRepository($productMagic360GalleryRepository);

    /**
     * Returns the repository to load magic360 gallery data.
     *
     * @return \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository The repository instance
     */
    public function getProductMagic360GalleryRepository();

    /**
     * Sets the repository to load magic360 column data.
     *
     * @param \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository $productMagic360ColumnsRepository The repository instance
     *
     * @return void
     */
    public function setProductMagic360ColumnsRepository($productMagic360ColumnsRepository);

    /**
     * Returns the repository to load magic360 column data.
     *
     * @return \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository The repository instance
     */
    public function getProductMagic360ColumnsRepository();

    /**
     * Sets the action with the magic360 gallery CRUD methods.
     *
     * @param \TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction $magic360GalleryAction The action with the magic360 gallery CRUD methods
     *
     * @return void
     */
    public function setMagic360GalleryAction($magic360GalleryAction);

    /**
     * Returns the action with the magic360 gallery CRUD methods.
     *
     * @return \TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction $magic360GalleryAction The action with the magic360 gallery CRUD methods
     */
    public function getMagic360GalleryAction();

    /**
     * Sets the action with the magic360 column CRUD methods.
     *
     * @param \TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction $magic360ColumnsAction The action with the magic360 column CRUD methods
     *
     * @return void
     */
    public function setMagic360ColumnsAction($magic360ColumnsAction);

    /**
     * Returns the action with the magic360 column CRUD methods.
     *
     * @return \TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction The action with the magic360 column CRUD methods
     */
    public function getMagic360ColumnsAction();

    /**
     * Persists the passed magic360 gallery data and returns the ID.
     *
     * @param array       $galleryEntry The magic360 gallery data to persist
     * @param string|null $name         The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistMagic360Gallery($galleryEntry, $name = null);

    /**
     * Persists the passed magic360 column data.
     *
     * @param array       $magic360Columns The magic360 gallery value data to persist
     * @param string|null $name            The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistMagic360Columns($magic360Columns, $name = null);

    /**
     * Persists the passed magic360 gallery data and returns the ID.
     *
     * @param array       $row  The magic360 gallery data to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Gallery($row, $name = null);

    /**
     * Persists the passed magic360 column data.
     *
     * @param array       $row  The magic360 column data to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Columns($row, $name = null);

    /**
     * Loads the magic360 gallery with the passed product ID and position
     *
     * @param integer $productId The product ID of the magic360 gallery to load
     * @param string  $position  The position of the magic360 gallery entry to load
     *
     * @return array The magic360 gallery
     */
    public function loadMagic360Gallery($productId, $position);

    /**
     * Loads the magic360 gallery with the passed product ID.
     *
     * @param integer $productId The product ID of the magic360 column to load
     *
     * @return array The magic360 gallery
     */
    public function loadMagic360Columns($productId);
}
