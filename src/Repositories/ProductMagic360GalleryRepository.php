<?php

/**
 * TechDivision\Import\Product\Magic360\Repositories\ProductMagic360GalleryRepository
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

namespace TechDivision\Import\Product\Magic360\Repositories;

use TechDivision\Import\Product\Magic360\Utils\MemberNames;
use TechDivision\Import\Repositories\AbstractRepository;

/**
 * Repository implementation to load product media gallery data.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class ProductMagic360GalleryRepository extends AbstractRepository
{

    /**
     * The prepared statement to load an existing product media gallery entity.
     *
     * @var \PDOStatement
     */
    protected $statement;

    /**
     * Initializes the repository's prepared statements.
     *
     * @return void
     */
    public function init()
    {

        // load the utility class name
        $utilityClassName = $this->getUtilityClassName();

        // initialize the prepared statements
        $this->statement = $this->getConnection()->prepare($utilityClassName::MAGIC360_GALLERY);
    }

    /**
     * Load's the product media gallery with the passed attribute ID + value.
     *
     * @param integer $productId The attribute ID of the product media gallery to load
     * @param integer $position  The value of the product media gallery to load
     *
     * @return array The product media gallery
     */
    public function findOneByProductIdAndPosition($productId, $position)
    {
        // load and return the product media gallery with the passed attribute ID + value
        $this->statement->execute(array(
            MemberNames::PRODUCT_ID => $productId,
            MemberNames::POSITION => $position
        ));

        return $this->statement->fetch(\PDO::FETCH_ASSOC);
    }
}
