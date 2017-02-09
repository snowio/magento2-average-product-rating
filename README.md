# Magento 2 Product Rating Extension

## Description
A Magento 2 module which exposes a products **average review rating** and **rating count**. These two fields are exposed
as extension attributes that are accessible via Product get API calls. Please refer to the Magento 2 DevDocs section on [Getting Started with Magento Web APIs](http://devdocs.magento.com/guides/v2.1/get-started/bk-get-started-api.html) for more information about
API access.

## Prerequisites
* PHP 7.0 or newer
* Composer  (https://getcomposer.org/download/).
* `magento/module-catalog` module 100, 101 or newer.
* `magento/module-review` module 100 or newer.
* `magento/module-store` module 100 or newer.
* `magento/framework` 100 or newer

## Installation
```
composer require snowio/magento2-product-rating-extension
php bin/magento module:enable SnowIO_ProductRatingExtension
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento cache:flush
```

## Usage
Once installed subsequent product requests will contain new `extension_attributes` with the fields `average_review_rating` and `ratings_count`.

* `average_review_rating` : The average rating of all reviews of the product.
* `ratings_count` : The number of review ratings.

## License
This software is licensed under the MIT License. [View the license](LICENSE)