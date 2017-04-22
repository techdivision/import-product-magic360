# M2IF - Product Magic360 Image Import

[![Latest Stable Version](https://img.shields.io/packagist/v/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360) 
 [![Total Downloads](https://img.shields.io/packagist/dt/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360)
 [![License](https://img.shields.io/packagist/l/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360)
 [![Build Status](https://img.shields.io/travis/techdivision/import-product-magic360/master.svg?style=flat-square)](http://travis-ci.org/techdivision/import-product-magic360)
 [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/techdivision/import-product-magic360/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-magic360/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/techdivision/import-product-magic360/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-magic360/?branch=master)

## Introduction

This module provides the functionality to import the images for the almost famous 
[Product Magic360](https://www.magictoolbox.com/magic360/) Magento 2 extension.

## Configuration

In case that the [M2IF - Simple Console Tool](https://github.com/techdivision/import-cli-simple) 
is used, the functionality can be enabled merging the following snippet to the used configuration 
file

```json
{
  "magento-edition": "CE",
  "magento-version": "2.1.2",
  "operation-name" : "replace",
  "installation-dir" : "/var/www/magento",
  "utility-class-name" : "TechDivision\\Import\\Utils\\SqlStatements",
  "database": { ... },
  "operations" : [
    {
      "name" : "replace",
      "subjects": [
        { ... },
        {
          "class-name": "TechDivision\\Import\\Product\\Subjects\\BunchSubject",
          ...,
          "observers": [
            {
              "import": [
                ...,
                "TechDivision\\Import\\Product\\Magic360\\Observers\\ProductMagic360Observer"
              ]
            },
            {
              "post-import": [ ... ]
            }
          ]
        },
        { ... },
        {
          "class-name": "TechDivision\\Import\\Product\\Magic360\\Subjects\\Magic360Subject",
          "processor-factory" : "TechDivision\\Import\\Product\\Magic360\\Services\\ProductMagic360ProcessorFactory",
          "utility-class-name" : "TechDivision\\Import\\Product\\Magic360\\Utils\\SqlStatements",
          "prefix": "magic360",
          "params" : [
            {
              "copy-images" : false,
              "root-directory" : "/",
              "media-directory" : "/opt/appserver/webapps/magento2_ce212/pub/media/catalog/product",
              "images-file-directory" : "projects/sample-data/magento2-sample-data/pub/media/catalog/product"
            }
          ],
          "observers": [
            {
              "pre-import" : [
                "TechDivision\\Import\\Product\\Magic360\\Observers\\ClearMagic360Observer",
                "TechDivision\\Import\\Product\\Media\\Observers\\FileUploadObserver"
              ],
              "import": [
                "TechDivision\\Import\\Product\\Magic360\\Observers\\Magic360GalleryObserver",
                "TechDivision\\Import\\Product\\Magic360\\Observers\\Magic360ColumnsObserver"
              ]
            }
          ]
        }
      ]
    },
    {
      "name" : "add-update",
      "subjects": [
        { ... },
        {
          "class-name": "TechDivision\\Import\\Product\\Subjects\\BunchSubject",
          ...,
          "observers": [
            {
              "import": [
                ...,
                "TechDivision\\Import\\Product\\Magic360\\Observers\\ProductMagic360Observer"
              ]
            },
            {
              "post-import": [ ... ]
            }
          ]
        },
        { ... },
        {
          "class-name": "TechDivision\\Import\\Product\\Magic360\\Subjects\\Magic360Subject",
          "processor-factory" : "TechDivision\\Import\\Product\\Magic360\\Services\\ProductMagic360ProcessorFactory",
          "utility-class-name" : "TechDivision\\Import\\Product\\Magic360\\Utils\\SqlStatements",
          "prefix": "magic360",
          "params" : [
            {
              "copy-images" : false,
              "root-directory" : "/",
              "media-directory" : "/opt/appserver/webapps/magento2_ce212/pub/media/catalog/product",
              "images-file-directory" : "projects/sample-data/magento2-sample-data/pub/media/catalog/product"
            }
          ],
          "observers": [
            {
              "pre-import" : [
                "TechDivision\\Import\\Product\\Magic360\\Observers\\ClearMagic360Observer",
                "TechDivision\\Import\\Product\\Media\\Observers\\FileUploadObserver"
              ],
              "import": [
                "TechDivision\\Import\\Product\\Magic360\\Observers\\Magic360GalleryUpateObserver",
                "TechDivision\\Import\\Product\\Magic360\\Observers\\Magic360ColumnsUpdateObserver"
              ]
            }
          ]
        }
      ]
    }
  ]
}
```

# Missing Index

For a massive improvement of the import performance, two indices have to be added.

To do that, open a MySQL command line and enter the following SQL statements.

```sql
ALTER TABLE `magic360_gallery` ADD INDEX `MAGIC360_GALLERY_PRODUCT_ID` (`product_id`);
ALTER TABLE `magic360_gallery` ADD INDEX `MAGIC360_GALLERY_POSITION` (`position`);
```