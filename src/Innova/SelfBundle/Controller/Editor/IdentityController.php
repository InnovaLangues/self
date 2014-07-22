<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class IdentityController
 * @Route(
 *      "admin/editor",
 *      name    = "",
 *      service = "innova_editor_identity"
 * )
 */

class QuestionnaireController
{
    protected $editorLogManager;
    protected $entityManager;
    protected $request;
    protected $templating;

    public function __construct(
            $editorLogManager,
            $entityManager,
            $templating
    )
    {
        $this->editorLogManager = $editorLogManager;
        $this->entityManager = $entityManager;
        $this->templating = $templating;

    }

    public function setRequest(Request $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @Route("/set-identity-attribute", name="set-identity-attribute", options={"expose"=true})
     * @Method("PUT")
     */
    public function setIdentityAttribute()
    {

    }
}
