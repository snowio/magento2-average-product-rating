<?php
//create a product
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\TestFramework\Helper\Bootstrap;

$objectManager = Bootstrap::getObjectManager();
$productRepository = $objectManager->get(ProductRepositoryInterface::class);
/** @var ProductInterface$productFactory */
$product = $objectManager->create(ProductInterface::class);
/** @var \Magento\Catalog\Model\Product $product */
$product->setTypeId('simple');
$product->setSku('test-snowio-product');
$product->setName('Test SnowIO Product');
$product->setPrice(1.00);
$product->setAttributeSetId(4);
$productRepository->save($product);
