<?php
namespace SnowIO\ProductRatingExtension\Api\Data;

interface ProductReviewInterface
{
    const AVERAGE_REVIEW_RATING = 'average_review_rating';
    const REVIEW_COUNT = 'review_count';
    const STORE_CODE = 'store_code';
    const STORE_ID = 'store_id';

    /**
     * @return float
     */
    public function getAverageReviewRating();

    /**
     * @return int
     */
    public function getRatingsCount();

    /**
     * @return string
     */
    public function getStoreCode();

    /**
     * @return int
     */
    public function getStoreId();

    /**
     * @param  float $averageReviewRating
     * @return $this
     */
    public function setAverageRatingReview($averageReviewRating);

    /**
     * @param int $ratingCount
     * @return $this
     */
    public function setRatingsCount($ratingCount);

    /**
     * @param string $storeCode
     * @return $this
     */
    public function setStoreCode($storeCode);

    /**
     * @param int $storeId
     * @return $this
     */
    public function setStoreId($storeId);
}
