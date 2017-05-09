<?php

namespace SnowIO\ProductRatingExtension\Model;

use SnowIO\ProductRatingExtension\Api\Data\ProductReviewInterface;
use SnowIO\ProductRatingExtension\Api\ReviewRepositoryInterface;
use SnowIO\ProductRatingExtension\Model\ProductReviewFactory;
use Magento\Review\Model\ReviewFactory;
use Magento\Store\Model\StoreManager;

class ReviewRepository implements ReviewRepositoryInterface
{

    private $reviewFactory;
    private $productRepository;
    private $storeManager;
    private $productReviewFactory;

    public function __construct(
        ReviewFactory $reviewFactory,
        ProductRepositoryInterface $productRepository,
        StoreManager $storeManager,
        ProductReviewFactory $productReviewFactory
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->productReviewFactory = $productReviewFactory;
    }

    /**
     * Get the reviews for a product from all stores
     * @api
     * @param int $productSku
     * @return \SnowIO\ProductRatingExtension\Api\Data\ProductReviewInterface[] $productReviews
     */
    public function get($productSku)
    {
        $stores = $this->storeManager->getStores();
        $storeIds = array_keys($stores);
        $product = $this->productRepository->get($productSku);
        $reviewsPerStore = [];

        foreach ($storeIds as $storeId) {
            /** @var ProductReviewInterface $productReview */
            $productReview = $this->productReviewFactory->create();
            $this->reviewFactory->create()->getEntitySummary($product, $storeId);
            $averageReviewRating = (float)$product->getRatingSummary()->getRatingSummary();
            $ratingsCount = $product->getRatingSummary()->getReviewsCount();

            $productReview
                ->setStoreId($storeId)
                ->setAverageRatingReview($averageReviewRating)
                ->setRatingsCount($ratingsCount);

            $reviewsPerStore[] = $productReview;
        }
        return $reviewsPerStore;
    }
}