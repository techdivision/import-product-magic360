<?php

/**
 * TechDivision\Import\Product\Magic360\Utils\ColumnKeys
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
 * Utility class containing the CSV column names.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class ColumnKeys extends \TechDivision\Import\Product\Utils\ColumnKeys
{

    /**
     * Name for the column 'is_360'.
     *
     * @var string
     */
    const IS_360 = 'is_360';

    /**
     * Name for the column 'images_360'.
     *
     * @var string
     */
    const IMAGES_360 = 'images_360';

    /**
     * Name for the column 'images_path'.
     *
     * @var string
     */
    const IMAGES_PATH = 'images_path';

    /**
     * Name for the column 'product_id'.
     *
     * @var integer
     */
    const PRODUCT_ID = 'product_id';

    /**
     * Name for the column 'id'.
     *
     * @var integer
     */
    const RECORD_ID = 'id';

    /**
     * Name for the column 'position'.
     *
     * @var string
     */
    const POSITION = 'position';

    /**
     * Name for the column 'file'.
     *
     * @var string
     */
    const FILE = 'file';

    /**
     * Name for the column 'image_path'.
     *
     * @var string
     */
    const IMAGE_PATH = 'image_path';

    /**
     * Name for the column 'image_path_new'.
     *
     * @var string
     */
    const IMAGE_PATH_NEW = 'image_path_new';
}
