<?php

namespace SnowIO\ProductRatingExtension\Test\Integration\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\ObjectManagerInterface;
use Magento\Review\Model\RatingFactory;
use Magento\Review\Model\Review;
use Magento\Review\Model\ReviewFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Reports\Model\ResourceModel\Review\Collection;

class ProductRatingExtensionPluginTest extends \PHPUnit_Framework_TestCase
{
    /** @var ObjectManagerInterface */
    private $objectManager;
    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var Collection */
    private $reviewCollection;

    /** @var  CustomerRepositoryInterface */
    private $customerRepository;

    /** @var  ReviewFactory */
    private $reviewFactory;

    private $storeId;

    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->objectManager = Bootstrap::getObjectManager();
        $this->productRepository = $this->objectManager->get(ProductRepositoryInterface::class);
        $this->reviewCollection = $this->objectManager->get(Collection::class);
        /** @var CustomerRepositoryInterface $customerRepository */
        $this->customerRepository = $this->objectManager->get(CustomerRepositoryInterface::class);
        $this->storeId = $this->objectManager->get(StoreManagerInterface::class)->getStore()->getId();
    }


    /**
     * @dataProvider standardCaseTestData
     * @magentoDataFixture SnowIO/ProductRatingExtension/Test/Integration/_files/product_rating.php
     */
    public function testReviewRatingAddedToLoadedProducts($inputReviews, $expectedRatingSummary)
    {
        $productId = $this->productRepository->get('test-snowio-product')->getId();
        foreach ($inputReviews as $inputReview) {
            $ratingFactory = $this->objectManager->get(RatingFactory::class);

            $ratingOptions = [
                1 => [1,2,3,4,5],
                2 => [6,7,8,9,10],
                3 => [11,12,13,14,15],
                4 => [16,17,18,19,20]
            ];
            $inputReview['review']->setEntityPkValue($productId);

            foreach ($ratingOptions as $ratingId => $optionId) {
                $ratingFactory->create()
                    ->setRatingId($ratingId)
                    ->setReviewId($inputReview['review']->getId())
                    ->addOptionVote($optionId[$inputReview['rating'] - 1], $productId);
            }

            $inputReview['review']->aggregate()->save();
        }

        $product = $this->productRepository->get('test-snowio-product');

        $averageReviewRating = $product->getExtensionAttributes()->getAverageReviewRating();

        $this->assertEquals($expectedRatingSummary, $averageReviewRating);

    }

    public function standardCaseTestData()
    {
        return [
            [ //Test case 1
                [
                    [
                        'rating' => 5, //Rating
                        'review' => $this->objectManager->get(ReviewFactory::class)->create()
                            ->setEntityId($this->storeId)// product
                            ->setStoreId($this->storeId)
                            ->setStores([$this->storeId])
                            ->setTitle('Test Title 123')
                            ->setDetail('Test detail data 123')
                            ->setNickname('Test nickname 123')
                            ->setStatusId(Review::STATUS_APPROVED)
                            ->setCustomerId(null), //Admin,
                    ],
                    [
                        'rating' => 3, //Rating
                        'review' => $this->objectManager->get(ReviewFactory::class)->create()
                            ->setEntityId($this->storeId)// product
                            ->setStoreId($this->storeId)
                            ->setStores([$this->storeId])
                            ->setTitle('Test Title 456')
                            ->setDetail('Test detail data 456')
                            ->setNickname('Test nickname 456')
                            ->setStatusId(Review::STATUS_APPROVED)
                            ->setCustomerId(null), //Admin,
                    ],
                    [
                        'rating' => 1, //Rating
                        'review' => $this->objectManager->get(ReviewFactory::class)->create()
                            ->setEntityId($this->storeId)// product
                            ->setStoreId($this->storeId)
                            ->setStores([$this->storeId])
                            ->setTitle('Test Title 456')
                            ->setDetail('Test detail data 456')
                            ->setNickname('Test nickname 456')
                            ->setStatusId(Review::STATUS_NOT_APPROVED)
                            ->setCustomerId(null), //Admin,
                    ]
                ],
                $expectedAverageRating = 80
            ]
        ];
    }
}
