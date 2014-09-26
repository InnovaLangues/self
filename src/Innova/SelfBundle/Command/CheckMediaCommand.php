<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckMediaCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:check:media')
            ->setDescription('Check media SELF')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $table = $this->getHelperSet()->get('table');

        $table->setHeaders(array('ID', 'TACHE', 'MEDIA', 'CAUSE'));

        $medias = $em->getRepository('InnovaSelfBundle:Media')->findAll();

        $patterns = array(
                        "<div",
                        "data-original-title",
                        "href",
                        "<xml>",
                        "<!--",
                        "MsoNormal",
                        );

        $numberOfErros = 0;
        foreach ($medias as $media) {
            foreach ($patterns as $pattern) {
                if (strstr($media->getDescription(),$pattern)){
                    if ($purpose = $media->getMediaPurpose()) {$purpose = "(".$purpose->getName().")";} else {$purpose = "";}
                    $table->addRow(array($media->getId(), $media->getName(), $purpose, $pattern));
                    $numberOfErros++;
                    break;
                }
            }
        }
        $table->addRow(array("", "", ""));
        $table->addRow(array("Nombre d'erreurs", $numberOfErros, "", ""));

        $table->render($output);


    }
}
