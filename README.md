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

In case that the [M2IF - Simple Console Tool](https://github.com/techdivision/import-cli-simple) < 3.8
is used, the functionality for the add-update and replace operations can be enabled merging the following 
snippet to the used configuration file

```json
{
  "magento-edition": "CE",
  "magento-version": "2.1.2",
  "operation-name" : "add-update",
  "database": { ... },
  "extension-libraries": [
    "techdivision/import-product-magic360"
  ],
  "additional-vendor-dirs": [
    {
      "vendor-dir": "app/code",
      "libraries": [
        "MyProject/Import"
      ]
    }
  ],
  "operations" : [
    {
      "name" : "replace",
      "subjects": [
        { ... },
        {
          "id": "import_product_magic360.subject.magic360",
          "file-resolver": {
            "prefix": "magic360"
          },
          "params" : [
            {
              "copy-images" : false
            }
          ],
          "observers": [
            {
              "import": [
                "import_product_magic360.observer.composite.replace"
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
          "id": "import_product_magic360.subject.magic360",
          "file-resolver": {
            "prefix": "magic360"
          },
          "params" : [
            {
              "copy-images" : false
            }
          ],
          "observers": [
            {
              "import": [
                "import_product_magic360.observer.composite.add_update"
              ]
            }
          ]
        }
      ]
    }
  ]
}
```

For the `delete` operation, it is necessary to override the Symfony DI configuration for the apropriate composite
observer. For example if you're using Magento CE, add a `MyProject/import/symfony/Resources/config/services.xml' 
with the following content, to override the default `import_product.observer.composite.base.delete` composite observer

```xml
<?xml version="1.0" encoding="UTF-8" ?>
<container xmlns="http://symfony.com/schema/dic/services"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/services http://symfony.com/schema/dic/services/services-1.0.xsd">
    <services>
        <!--
         | The DI configuration for the composite observers of the delete operation.
         |-->
        <service id="import_product.observer.composite.base.delete" class="TechDivision\Import\Observers\GenericCompositeObserver">
            <call method="addObserver">
                <argument id="import_product_magic360.observer.sku.entity.id.mapping" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_msi.observer.product.source.item.default" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_url_rewrite.observer.clear.url.rewrite" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_magic360.observer.clear.magic360" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.clear.product" type="service"/>
            </call>
        </service>
    </services>
</container>
```

# Missing Index

For a massive improvement of the import performance, two indices have to be added.

To do that, open a MySQL command line and enter the following SQL statements.

```sql
ALTER TABLE `magic360_gallery` ADD INDEX `MAGIC360_GALLERY_PRODUCT_ID` (`product_id`);
ALTER TABLE `magic360_gallery` ADD INDEX `MAGIC360_GALLERY_POSITION` (`position`);
```