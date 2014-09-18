<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\TableHelper;

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

        $table->setHeaders(array('ID', 'TACHE', 'MEDIA'));

        $medias = $em->getRepository('InnovaSelfBundle:Media')->findAll();

        $patterns = array(
                        "<div",
                        "original",
                        "href",
                        "<xml>",
                        "<!--",
                        "MsoNormal",
                        );

        foreach ($medias as $media) {
            foreach ($patterns as $pattern) {
                if (strstr($media->getDescription(),$pattern)){
                    if ($purpose = $media->getMediaPurpose()) {$purpose = "(".$purpose->getName().")";} else {$purpose = "";}
                    $table->addRow(array($media->getId(), $media->getName(), $purpose));
                    break;
                }
            }
        }

        $table->render($output);

    }
}
