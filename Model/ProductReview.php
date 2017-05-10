<?php

namespace  SnowIO\ProductRatingExtension\Model;

use Magento\Framework\DataObject;
use SnowIO\ProductRatingExtension\Api\Data\ProductReviewInterface;

class ProductReview extends DataObject implements ProductReviewInterface
{

    /**
     * @return float
     */
    public function getAverageReviewRating()
    {
        return $this->getData(ProductReviewInterface::AVERAGE_REVIEW_RATING);
    }

    /**
     * @return int
     */
    public function getRatingsCount()
    {
        return $this->getData(ProductReviewInterface::REVIEW_COUNT);
    }

    /**
     * @param  float $averageReviewRating
     * @return $this
     */
    public function setAverageRatingReview($averageReviewRating)
    {
        return $this->setData(ProductReviewInterface::AVERAGE_REVIEW_RATING, $averageReviewRating);
    }

    /**
     * @param int $ratingCount
     * @return $this
     */
    public function setRatingsCount($ratingCount)
    {
        return $this->setData(ProductReviewInterface::REVIEW_COUNT, $ratingCount);
    }

    /**
     * @return string
     */
    public function getStoreCode()
    {
        return $this->getData(ProductReviewInterface::STORE_CODE);
    }

    /**
     * @param string $storeCode
     * @return $this
     */
    public function setStoreCode($storeCode)
    {
        return $this->setData(ProductReviewInterface::STORE_CODE, $storeCode);
    }

    /**
     * @return int
     */
    public function getStoreId()
    {
        return $this->getData(ProductReviewInterface::STORE_ID);
    }

    /**
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId)
    {
        return $this->setData(ProductReviewInterface::STORE_ID, $storeId);
    }
}
