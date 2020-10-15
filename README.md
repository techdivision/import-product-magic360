# Pacemaker - Product Magic360 Image Import

[![Latest Stable Version](https://img.shields.io/packagist/v/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360) 
 [![Total Downloads](https://img.shields.io/packagist/dt/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360)
 [![License](https://img.shields.io/packagist/l/techdivision/import-product-magic360.svg?style=flat-square)](https://packagist.org/packages/techdivision/import-product-magic360)
 [![Build Status](https://img.shields.io/travis/techdivision/import-product-magic360/master.svg?style=flat-square)](http://travis-ci.org/techdivision/import-product-magic360)
 [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/techdivision/import-product-magic360/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-magic360/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/techdivision/import-product-magic360/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/techdivision/import-product-magic360/?branch=master)

Please visit the Pacemaker [website](https://pacemaker.techdivision.com) or our [documentation](https://docs.met.tdintern.de/pacemaker/1.3/) for additional information

## Introduction

This module provides the functionality to import the images for the almost famous 
[Product Magic360](https://www.magictoolbox.com/magic360/) Magento 2 extension.

## Configuration

In case that the [Pacemaker - Simple Console Tool](https://github.com/techdivision/import-cli-simple) >= 3.8
is used, the functionality for the add-update and replace operations can be enabled add the following
snippets to your `<magento-install-dir>/app/etc/configuration` directory.

The first snippet is `<magento-install-dir>/app/etc/configuration/shortcuts.json`, which overrides the default
shortcuts and finally adds the `general/catalog_product/replace.magic360` operation to the `replace` and 
`add-update` operations

```json
{
  "shortcuts": {
    "ce": {
      "catalog_product": {
        "replace": [
          "general/general/global-data",
          "general/general/move-files",
          "general/catalog_product/collect-data",
          "general/eav_attribute/convert",
          "general/eav_attribute/add-update.options",
          "general/eav_attribute/add-update.option-values",
          "general/eav_attribute/add-update.swatch-values",
          "general/catalog_category/convert",
          "ce/catalog_category/sort",
          "ce/catalog_category/add-update",
          "ce/catalog_category/add-update.path",
          "ce/catalog_category/add-update.url-rewrite",
          "general/catalog_category/children-count",
          "general/catalog_product/validate",
          "ce/catalog_product/replace",
          "ce/catalog_product/replace.variants",
          "ce/catalog_product/replace.bundles",
          "ce/catalog_product/replace.links",
          "ce/catalog_product/replace.grouped",
          "ce/catalog_product/replace.media",
          "general/catalog_product/replace.msi",
          "general/catalog_product/replace.url-rewrites",
          "general/catalog_product/replace.magic360"
        ],
        "add-update": [
          "general/general/global-data",
          "general/general/move-files",
          "general/catalog_product/collect-data",
          "general/eav_attribute/convert",
          "general/eav_attribute/add-update.options",
          "general/eav_attribute/add-update.option-values",
          "general/eav_attribute/add-update.swatch-values",
          "general/catalog_category/convert",
          "ce/catalog_category/sort",
          "ce/catalog_category/add-update",
          "ce/catalog_category/add-update.path",
          "ce/catalog_category/add-update.url-rewrite",
          "general/catalog_category/children-count",
          "general/catalog_product/validate",
          "ce/catalog_product/add-update",
          "ce/catalog_product/add-update.variants",
          "ce/catalog_product/add-update.bundles",
          "ce/catalog_product/add-update.links",
          "ce/catalog_product/add-update.grouped",
          "ce/catalog_product/add-update.media",
          "general/catalog_product/add-update.msi",
          "general/catalog_product/add-update.url-rewrites",
          "general/catalog_product/add-update.magic360"
        ]
      }
    }
  }
}
```

The second and the third snippets makes the `techdivision/import-product-magic360` extension classes available for 
the importer. So add the snippet `<magento-install-dir>/app/etc/configuration/extension-libraries.json` with the
content

```json
{
  "extension-libraries": [
    "techdivision/import-product-magic360"
  ]
}
```

and the snippet `<magento-install-dir>/app/etc/configuration/additional-vendor-dirs.json` containing the following
content

```json
{
  "additional-vendor-dirs": [
    {
      "vendor-dir": "app/code",
      "libraries": [
        "MyProject/Import"
      ]
    }
  ]
}
```

assumung that your `<magento-install-dir>/app/code` contains the Magento extension `MyProject/Import`.

Finally, it is necessary to override the Symfony DI configuration for the apropriate composite observers. For example 
if you're using Magento CE, add a `<magento-install-dir>/app/codeMyProject/import/symfony/Resources/config/services.xml` with 
the following content, to override the default composite observer

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
        <!--
         | The DI configuration for the composite observers of the replace operation.
         |-->
        <service id="import_product.observer.composite.base.replace" class="TechDivision\Import\Observers\GenericCompositeObserver">
            <call method="addObserver">
                <argument id="import_product_url_rewrite.observer.clear.url.rewrite" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.clear.product" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import.observer.attribute.set" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import.observer.additional.attribute" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.url.key" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.file.upload" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.quality.and.stock.status" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.website" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.category.product" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.inventory" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.attribute" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_url_rewrite.observer.product.url.rewrite" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_variant.observer.product.variant" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_bundle.observer.product.bundle" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_media.observer.product.media" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_link.observer.product.link" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_grouped.observer.product.grouped" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_msi.observer.product.source.item.default" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_magic360.observer.product.magic360" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.clean.up" type="service"/>
            </call>
        </service>
        <!--
         | The DI configuration for the composite observers of the add-update operation.
         |-->
        <service id="import_product.observer.composite.base.add_update" class="TechDivision\Import\Observers\GenericCompositeObserver">
            <call method="addObserver">
                <argument id="import.observer.attribute.set" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import.observer.additional.attribute" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.url.key" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.file.upload" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.quality.and.stock.status" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.website.update" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.category.product.update" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.inventory.update" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.product.attribute.update" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_url_rewrite.observer.product.url.rewrite" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_variant.observer.product.variant" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_bundle.observer.product.bundle" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_media.observer.product.media" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_media.observer.clear.media.gallery" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_link.observer.product.link" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_grouped.observer.product.grouped" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_msi.observer.product.source.item.default" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product_magic360.observer.product.magic360" type="service"/>
            </call>
            <call method="addObserver">
                <argument id="import_product.observer.clean.up" type="service"/>
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
