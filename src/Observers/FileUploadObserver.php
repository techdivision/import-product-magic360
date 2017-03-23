<?php

/**
 * TechDivision\Import\Product\Magic360\Observers\FileUploadObserver
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

namespace TechDivision\Import\Product\Magic360\Observers;

use TechDivision\Import\Product\Media\Utils\ColumnKeys;
use TechDivision\Import\Observers\AbstractFileUploadObserver;

/**
 * Observer that uploads the file specified in a CSV file's column 'image_path' to a
 * configurable directoy.
 *
 * @author    Tim Wagner <t.wagner@techdivision.com>
 * @author    Bernhard Wick <b.wick@techdivision.com>
 * @copyright 2017 TechDivision GmbH <info@techdivision.com>
 * @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @link      https://github.com/techdivision/import-product-magic360
 * @link      http://www.techdivision.com
 */
class FileUploadObserver extends AbstractFileUploadObserver
{

    /**
     * Return's the name of the source column with the image path.
     *
     * @return string The image path
     */
    protected function getSourceColumn()
    {
        return ColumnKeys::IMAGE_PATH;
    }

    /**
     * Return's the target column with the path of the copied image.
     *
     * @return string The path to the copied image
     */
    protected function getTargetColumn()
    {
        return ColumnKeys::IMAGE_PATH_NEW;
    }
}
