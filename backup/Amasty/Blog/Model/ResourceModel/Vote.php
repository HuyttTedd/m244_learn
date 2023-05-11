<?php

namespace Amasty\Blog\Model\ResourceModel;

use Amasty\Blog\Api\Data\VoteInterface;

/**
 * Class Vote
 */
class Vote extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Model Initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(VoteInterface::MAIN_TABLE, VoteInterface::VOTE_ID);
    }
}
