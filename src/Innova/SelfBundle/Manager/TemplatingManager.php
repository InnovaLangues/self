<?php

namespace Innova\SelfBundle\Manager;

class TemplatingManager
{
    protected $entityManager;
    protected $templating;

    public function __construct($entityManager, $templating)
    {
        $this->entityManager = $entityManager;
        $this->templating = $templating;
    }

    public function generateView($case, $parameters)
    {
        switch ($case) {
            case 'contexte':
                $template = 'InnovaSelfBundle:Editor/partials:contexte.html.twig';
                break;
            case 'texte':
                $template =  'InnovaSelfBundle:Editor/partials:texte.html.twig';
                break;
            case 'functional-instruction':
                $template = 'InnovaSelfBundle:Editor/partials:functionalInstruction.html.twig';
                break;
            case 'feedback':
                $template = 'InnovaSelfBundle:Editor/partials:feedback.html.twig';
                break;
            case 'instruction':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'subquestion':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'blank-text':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'comments':
                $template = 'InnovaSelfBundle:Editor/partials:comments.html.twig';
                break;
            case 'comment':
                $template = 'InnovaSelfBundle:Editor/partials:comments.html.twig';
                break;
            case 'amorce':
                $template = 'InnovaSelfBundle:Editor/partials:subquestion.html.twig';
                break;
            case 'app-media':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'app-answer':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'app-distractor':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'app-paire':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case 'distractor':
                $template = 'InnovaSelfBundle:Editor/partials:subquestion.html.twig';
                break;
            case 'proposition':
                $template = 'InnovaSelfBundle:Editor/partials:subquestion.html.twig';
                break;
            case 'null':
                $template = 'InnovaSelfBundle:Editor/partials:subquestions.html.twig';
                break;
            case '':
                $template = 'InnovaSelfBundle:Editor/partials:proposition.html.twig';
                break;
        }

        $view = $this->templating->render($template, $parameters);

        return $view;
    }
}
