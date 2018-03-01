<?php

/**
 * TechDivision\Import\Product\Magic360\Repositories\SqlStatementRepository
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
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */

namespace TechDivision\Import\Product\Magic360\Repositories;

use TechDivision\Import\Product\Magic360\Utils\SqlStatementKeys;
use TechDivision\Import\Repositories\AbstractSqlStatementRepository;

/**
 * Repository class with the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2018 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class SqlStatementRepository extends AbstractSqlStatementRepository
{

    /**
     * The SQL statements.
     *
     * @var array
     */
    private $statements = array(
        SqlStatementKeys::MAGIC360_GALLERY =>
            'SELECT *
               FROM magic360_gallery
              WHERE product_id = :product_id
                AND position = :position',
        SqlStatementKeys::MAGIC360_COLUMNS =>
            'SELECT *
               FROM magic360_columns
              WHERE product_id = :product_id',
        SqlStatementKeys::CREATE_MAGIC360_GALLERY =>
            'INSERT
               INTO magic360_gallery
                    (product_id,
                     position,
                     file)
             VALUES (:product_id,
                     :position,
                     :file)',
        SqlStatementKeys::UPDATE_MAGIC360_GALLERY =>
            'UPDATE magic360_gallery
                SET product_id = :product_id,
                    position = :position,
                    file = :file
              WHERE id = :id',
        SqlStatementKeys::DELETE_MAGIC360_GALLERY =>
            'DELETE FROM magic360_gallery WHERE product_id = :product_id',
        SqlStatementKeys::CREATE_MAGIC360_COLUMNS =>
            'INSERT
               INTO magic360_columns
                    (product_id,
                     columns)
             VALUES (:product_id,
                     :columns)',
        SqlStatementKeys::UPDATE_MAGIC360_COLUMNS =>
            'SqlStatementKeys magic360_columns
                SET product_id = :product_id,
                    columns = :columns
              WHERE product_id = :product_id',
        SqlStatementKeys::DELETE_MAGIC360_COLUMNS =>
            'DELETE FROM magic360_columns WHERE product_id = :product_id',
    );

    /**
     * Initialize the the SQL statements.
     */
    public function __construct()
    {

        // merge the class statements
        foreach ($this->statements as $key => $statement) {
            $this->preparedStatements[$key] = $statement;
        }
    }
}
