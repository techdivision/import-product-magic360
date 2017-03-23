<?php

/**
 * TechDivision\Import\Product\Magic360\Services\ProductMagic360Processor
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
class ProductMagic360Processor implements ProductMagic360ProcessorInterface
{

    /**
     * A PDO connection initialized with the values from the Doctrine EntityManager.
     *
     * @var \PDO
     */
    protected $connection;

    /**
     * The repository to load magic360 galleries.
     *
     * @var \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository
     */
    protected $productMagic360GalleryRepository;

    /**
     * The repository to load magic360 gallery to entities.
     *
     * @var \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository
     */
    protected $productMagic360ColumnsRepository;

    /**
     * The action with the magic360 gallery CRUD methods.
     *
     * @var \TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction
     */
    protected $magic360GalleryAction;

    /**
     * The action with the magic360 gallery value CRUD methods.
     *
     * @var \TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction
     */
    protected $magic360ColumnsAction;

    /**
     * Sets the passed connection.
     *
     * @param \PDO $connection The connection to set
     *
     * @return void
     */
    public function setConnection(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns the connection.
     *
     * @return \PDO The connection instance
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * Turns off autocommit mode. While autocommit mode is turned off, changes made to the database via the PDO
     * object instance are not committed until you end the transaction by calling ProductProcessor::commit().
     * Calling ProductProcessor::rollBack() will roll back all changes to the database and return the connection
     * to autocommit mode.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.begintransaction.php
     */
    public function beginTransaction()
    {
        return $this->connection->beginTransaction();
    }

    /**
     * Commits a transaction, returning the database connection to autocommit mode until the next call to
     * ProductProcessor::beginTransaction() starts a new transaction.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.commit.php
     */
    public function commit()
    {
        return $this->connection->commit();
    }

    /**
     * Rolls back the current transaction, as initiated by ProductProcessor::beginTransaction().
     *
     * If the database was set to autocommit mode, this function will restore autocommit mode after it has
     * rolled back the transaction.
     *
     * Some databases, including MySQL, automatically issue an implicit COMMIT when a database definition
     * language (DDL) statement such as DROP TABLE or CREATE TABLE is issued within a transaction. The implicit
     * COMMIT will prevent you from rolling back any other changes within the transaction boundary.
     *
     * @return boolean Returns TRUE on success or FALSE on failure
     * @link http://php.net/manual/en/pdo.rollback.php
     */
    public function rollBack()
    {
        return $this->connection->rollBack();
    }

    /**
     * Sets the repository to load magic360 gallery data.
     *
     * @param \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository $productMagic360GalleryRepository The repository instance
     *
     * @return void
     */
    public function setProductMagic360GalleryRepository($productMagic360GalleryRepository)
    {
        $this->productMagic360GalleryRepository = $productMagic360GalleryRepository;
    }

    /**
     * Returns the repository to load magic360 gallery data.
     *
     * @return \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository The repository instance
     */
    public function getProductMagic360GalleryRepository()
    {
        return $this->productMagic360GalleryRepository;
    }

    /**
     * Sets the repository to load magic360 column data.
     *
     * @param \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository $productMagic360ColumnsRepository The repository instance
     *
     * @return void
     */
    public function setProductMagic360ColumnsRepository($productMagic360ColumnsRepository)
    {
        $this->productMagic360ColumnsRepository = $productMagic360ColumnsRepository;
    }

    /**
     * Returns the repository to load magic360 column data.
     *
     * @return \TechDivision\Import\Product\Magic360\Repositories\ProductMagic360ColumnsRepository The repository instance
     */
    public function getProductMagic360ColumnsRepository()
    {
        return $this->productMagic360ColumnsRepository;
    }

    /**
     * Sets the action with the magic360 gallery CRUD methods.
     *
     * @param \TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction $magic360GalleryAction The action with the magic360 gallery CRUD methods
     *
     * @return void
     */
    public function setMagic360GalleryAction($magic360GalleryAction)
    {
        $this->magic360GalleryAction = $magic360GalleryAction;
    }

    /**
     * Returns the action with the magic360 gallery CRUD methods.
     *
     * @return \TechDivision\Import\Product\Magic360\Actions\Magic360GalleryAction $magic360GalleryAction The action with the magic360 gallery CRUD methods
     */
    public function getMagic360GalleryAction()
    {
        return $this->magic360GalleryAction;
    }

    /**
     * Sets the action with the magic360 column CRUD methods.
     *
     * @param \TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction $magic360ColumnsAction The action with the magic360 column CRUD methods
     *
     * @return void
     */
    public function setMagic360ColumnsAction($magic360ColumnsAction)
    {
        $this->magic360ColumnsAction = $magic360ColumnsAction;
    }

    /**
     * Returns the action with the magic360 column CRUD methods.
     *
     * @return \TechDivision\Import\Product\Magic360\Actions\Magic360ColumnsAction The action with the magic360 column CRUD methods
     */
    public function getMagic360ColumnsAction()
    {
        return $this->magic360ColumnsAction;
    }

    /**
     * Persists the passed magic360 gallery data and returns the ID.
     *
     * @param array       $galleryEntry The magic360 gallery data to persist
     * @param string|null $name         The name of the prepared statement that has to be executed
     *
     * @return string The ID of the persisted entity
     */
    public function persistMagic360Gallery($galleryEntry, $name = null)
    {
        return $this->getMagic360GalleryAction()->persist($galleryEntry, $name);
    }

    /**
     * Persists the passed magic360 column data.
     *
     * @param array       $magic360Columns The magic360 gallery value data to persist
     * @param string|null $name            The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function persistMagic360Columns($magic360Columns, $name = null)
    {
        $this->getMagic360ColumnsAction()->persist($magic360Columns, $name);
    }

    /**
     * Persists the passed magic360 gallery data and returns the ID.
     *
     * @param array       $row  The magic360 gallery data to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Gallery($row, $name = null)
    {
        $this->getMagic360GalleryAction()->delete($row, $name);
    }

    /**
     * Persists the passed magic360 column data.
     *
     * @param array       $row  The magic360 column data to persist
     * @param string|null $name The name of the prepared statement that has to be executed
     *
     * @return void
     */
    public function deleteMagic360Columns($row, $name = null)
    {
        $this->getMagic360ColumnsAction()->delete($row, $name);
    }

    /**
     * Loads the magic360 gallery with the passed product ID and position
     *
     * @param integer $productId The product ID of the magic360 gallery to load
     * @param string  $position  The position of the magic360 gallery entry to load
     *
     * @return array The magic360 gallery
     */
    public function loadMagic360Gallery($productId, $position)
    {
        return $this->getProductMagic360GalleryRepository()->findOneByProductIdAndPosition($productId, $position);
    }

    /**
     * Loads the magic360 gallery with the passed product ID.
     *
     * @param integer $productId The product ID of the magic360 column to load
     *
     * @return array The magic360 gallery
     */
    public function loadMagic360Columns($productId)
    {
        return $this->getProductMagic360ColumnsRepository()->findOneByProductId($productId);
    }
}