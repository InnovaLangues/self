<?php

namespace Innova\SelfBundle\Controller\Editor;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Innova\SelfBundle\Entity\Test;

/**
 * Test controller.
 *
 * @Route("admin/editor")
 */
class PhasedTestController extends Controller
{
    /**
     * Toggle phased attribute of a test entity.
     *
     * @Route("/test/{testId}/phase", name="editor_test_phase")
     * @Method("GET")
     * @Template("")
     */
    public function phaseTestAction($testId)
    {
        $em = $this->getDoctrine()->getManager();

        $test = $em->getRepository('InnovaSelfBundle:Test')->find($testId);
        $test = $this->get("self.test.manager")->togglePhased($test);

        if ($test->getPhased()) {
            $msg = 'Le test '.$test->getName().' est maintenant un test a étape';
        } else {
            $msg = 'Le test '.$test->getName().' n\'est plus un test a étape';
        }
        $this->get('session')->getFlashBag()->set('success', $msg);

        return $this->redirect($this->generateUrl('editor_tests_show'));
    }
}
