<?php

namespace SnowIO\ProductRatingExtension\Api;

interface ReviewRepositoryInterface
{

    /**
     * Get the reviews for a product from all stores
     * @api
     * @param string $productSku
     * @return \SnowIO\ProductRatingExtension\Api\Data\ProductReviewInterface[] $productReviews
     */
    public function get($productSku);
}