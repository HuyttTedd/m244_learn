<?php

namespace Amasty\Blog\Controller\Index;

use Amasty\Blog\Api\CommentRepositoryInterface;
use Amasty\Blog\Api\PostRepositoryInterface;
use Magento\Framework\App\Action;
use Magento\Framework\App\Action\Context;

class Form extends Action\Action
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    public function __construct(
        Context $context,
        PostRepositoryInterface $postRepository,
        CommentRepositoryInterface $commentRepository
    ) {
        parent::__construct($context);

        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|void
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $result = [];

        $postId = (int)$this->getRequest()->getParam('post_id');
        $sessionId = $this->getRequest()->getParam('session_id');
        try {
            if ($postId) {
                $post = $this->postRepository->getById($postId);
                $replyTo = (int)$this->getRequest()->getParam('reply_to');

                if ($replyTo) {
                    $comment = $this->commentRepository->getById($replyTo);
                }
                /** @var \Amasty\Blog\Block\Comments\Form $form */
                $form = $this->_view->getLayout()->createBlock(\Amasty\Blog\Block\Comments\Form::class);
                if ($form) {
                    $form->setPost($post)->setSessionId($sessionId);
                    if (isset($comment)) {
                        $form->setReplyTo($comment);
                    }
                    $form->setIsAjaxRendering(true);
                    $result['form'] = $form->toHtml();
                }
            }
        } catch (\Exception $e) {
            $result['error'] = $e->getMessage();
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        $this->getResponse()
            ->setHeader('Content-Type', 'application/json')
            ->setBody(\Zend_Json::encode($result));
    }
}
