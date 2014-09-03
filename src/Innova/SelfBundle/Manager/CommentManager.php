<?php

namespace Innova\SelfBundle\Manager;

use Innova\SelfBundle\Entity\Comment;
use Innova\SelfBundle\Entity\Questionnaire;
use Innova\SelfBundle\Entity\Media;

class CommentManager
{
    protected $entityManager;
    private $securityContext;

    public function __construct($entityManager, $securityContext)
    {
        $this->entityManager = $entityManager;
        $this->securityContext = $securityContext;
    }

    public function createComment(Questionnaire $questionnaire, Media $media)
    {
        $user = $this->securityContext->getToken()->getUser();
        $em = $this->entityManager;

        $comment = new Comment();
        $comment->setDescription($media);
        $comment->setDate(new \Datetime());
        $comment->setUser($user);
        $comment->setQuestionnaire($questionnaire);
        $em->persist($comment);
        $em->flush();

        return $comment;
    }
}
