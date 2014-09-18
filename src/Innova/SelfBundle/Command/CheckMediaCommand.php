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

        $output->writeln("");
        $output->writeln("Vérification des MEDIAS en cours ...");
        $output->writeln("");
        $output->writeln("<error>ID</error> NOM");
        $output->writeln("");

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
                    $output->writeln("<error>".$media->getId() . "</error> " . $media->getName() . " ".$purpose);
                    break;
                 }
            }
        }
    }
}
