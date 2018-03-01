<?php

/**
 * TechDivision\Import\Product\Magic360\Utils\SqlStatementKeys
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

namespace TechDivision\Import\Product\Magic360\Utils;

/**
 * Utility class with keys of the SQL statements to use.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class SqlStatementKeys
{

    /**
     * The SQL statement to load an existing magic360 gallery byproduct ID and position.
     *
     * @var string MAGIC360_GALLERY
     */
    const MAGIC360_GALLERY = 'magic360_gallery';

    /**
     * The SQL statement to load an existing magic360 column by product ID.
     *
     * @var string MAGIC360_COLUMNS
     */
    const MAGIC360_COLUMNS = 'magic360_colums';

    /**
     * The SQL statement to create a new magic360 gallery entry.
     *
     * @var string CREATE_MAGIC360_GALLERY
     */
    const CREATE_MAGIC360_GALLERY = 'create.magic360_gallery';

    /**
     * The SQL statement to update an existing magic360 gallery entry.
     *
     * @var string UPDATE_MAGIC360_GALLERY
     */
    const UPDATE_MAGIC360_GALLERY = 'update.magic360_gallery';

    /**
     * The SQL statement to delete an existing magic360 gallery entry.
     *
     * @var string DELETE_MAGIC360_GALLERY
     */
    const DELETE_MAGIC360_GALLERY = 'delete.magic360_gallery';

    /**
     * The SQL statement to create a new magic360 column entry.
     *
     * @var string CREATE_MAGIC360_COLUMNS
     */
    const CREATE_MAGIC360_COLUMNS = 'create.magic360_columns';

    /**
     * The SQL statement to update an existing magic360 column entry.
     *
     * @var string UPDATE_MAGIC360_COLUMNS
     */
    const UPDATE_MAGIC360_COLUMNS = 'update.magic360_columns';

    /**
     * The SQL statement to update an existing magic360 column entry.
     *
     * @var string DELETE_MAGIC360_COLUMNS
     */
    const DELETE_MAGIC360_COLUMNS = 'delete.magic360_columns';
}
