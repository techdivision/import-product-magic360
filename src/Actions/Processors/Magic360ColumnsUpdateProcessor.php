<?php

/**
 * TechDivision\Import\Product\Magic360\Actions\Processors\Magic360ColumnsUpdateProcessor
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

namespace TechDivision\Import\Product\Magic360\Actions\Processors;

use TechDivision\Import\Product\Magic360\Utils\MemberNames;
use TechDivision\Import\Product\Magic360\Utils\SqlStatementKeys;
use TechDivision\Import\Dbal\Collection\Actions\Processors\AbstractBaseProcessor;

/**
 * The magic360 columns update processor implementation.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class Magic360ColumnsUpdateProcessor extends AbstractBaseProcessor
{

    /**
     * Returns the array with the SQL statements that has to be prepared.
     *
     * @return array The SQL statements to be prepared
     * @see AbstractBaseProcessor::getStatements()
     */
    protected function getStatements()
    {
        // return the array with the SQL statements that has to be prepared
        return array(
            SqlStatementKeys::UPDATE_MAGIC360_COLUMNS => $this->loadStatement(SqlStatementKeys::UPDATE_MAGIC360_COLUMNS)
        );
    }

    /**
     * Update's the passed row.
     *
     * @param array       $row                  The row to persist
     * @param string|null $name                 The name of the prepared statement that has to be executed
     * @param string|null $primaryKeyMemberName The primary key member name of the entity to use
     *
     * @return string The ID of the updated entity
     */
    public function execute($row, $name = null, $primaryKeyMemberName = null)
    {
        parent::execute($row, $name);
        return $row[MemberNames::PRODUCT_ID];
    }
}
