<?php

namespace SnowIO\ProductRatingExtension\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\Data\ProductExtensionFactory;
use Magento\Review\Model\ReviewFactory;
use Magento\Store\Model\StoreManager;

class ProductRatingExtensionPlugin
{

    private $reviewFactory;
    private $storeManager;
    private $productExtensionFactory;

    public function __construct(
        ReviewFactory $reviewFactory,
        StoreManager $storeManager,
        ProductExtensionFactory $productExtensionFactory
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->storeManager = $storeManager;
        $this->productExtensionFactory = $productExtensionFactory;
    }


    public function afterGet(
        ProductRepositoryInterface $productRepositoryInterface,
        ProductInterface $product
    ) {
        $storeId = $this->storeManager->getStore()->getId();
        $this->reviewFactory->create()->getEntitySummary($product, $storeId);
        $ratingSummary = (float)$product->getRatingSummary()->getRatingSummary();
        $product->setExtensionAttributes(
            $this->productExtensionFactory
                ->create()
                ->setAverageReviewRating($ratingSummary)
        );

        return $product;
    }

    public function afterGetById(
        ProductRepositoryInterface $productRepositoryInterface,
        ProductInterface $product
    ) {
        return $this->afterGet($productRepositoryInterface, $product);
    }
}
