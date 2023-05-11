<?php

namespace Amasty\Blog\Cron;

use Amasty\Blog\Api\Data\PostInterface;
use Amasty\Blog\Api\PostRepositoryInterface;
use Amasty\Blog\Model\ResourceModel\Posts as PostsResource;
use Amasty\Blog\Model\Source\PostStatus;
use Magento\Cron\Model\Schedule;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Stdlib\DateTime;
use Zend_Date_Exception;

class Scheduled
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var ResourceConnection
     */
    private $resourceConnection;

    /**
     * @var PostsResource
     */
    private $postResource;

    public function __construct(
        PostRepositoryInterface $postRepository,
        ResourceConnection $resourceConnection,
        PostsResource $postResource
    ) {
        $this->postRepository = $postRepository;
        $this->resourceConnection = $resourceConnection;
        $this->postResource = $postResource;
    }

    /**
     * @param Schedule $schedule
     * @throws Zend_Date_Exception
     * @throws CouldNotSaveException
     */
    public function execute(Schedule $schedule)
    {
        $connection = $this->resourceConnection->getConnection();
        $storeTableName = $this->postResource->getTable(PostInterface::POSTS_STORE_TABLE);
        $now = new \Zend_Date();
        $select = $connection
            ->select()
            ->from($storeTableName, ['post_id', 'store_id'])
            ->where('status = :status AND published_at < :published_at');
        $storeRows = $connection->fetchAssoc($select, [
            'status' => PostStatus::STATUS_SCHEDULED,
            'published_at' => $now->toString(DateTime::DATETIME_INTERNAL_FORMAT)
        ]);
        if ($storeRows) {
            foreach ($storeRows as $storeRow) {
                $storeUpdate = [PostInterface::STATUS => PostStatus::STATUS_ENABLED];
                $condition = [
                    PostInterface::POST_ID . ' = ?' => $storeRow['post_id'],
                    PostInterface::STORE_ID . ' = ?' => $storeRow['store_id'],
                ];
                $connection->update($storeTableName, $storeUpdate, $condition);
            }
        }
    }
}
