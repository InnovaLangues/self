<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Symfony command to delete tests. EV. 12/03/2014
 * We must execute this command with parameter "sql" like :
 * php app/console self:delete:all sql
*/
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
        $output->writeln("NOM | DESCRIPTION | ID");
        $output->writeln("");

        $medias = $em->getRepository('InnovaSelfBundle:Media')->findAll();
        foreach ($medias as $media) {
            if (
                strstr($media->getDescription(),"<div")
                or strstr($media->getDescription(),"original")
                or strstr($media->getDescription(),"href")
                or strstr($media->getDescription(),"ffice")
            ) {
                $output->writeln($media->getId() . " | " . $media->getName() . " | " . $media->getDescription());
                $output->writeln("");
                $output->writeln("");
            }
        }

    }

}
