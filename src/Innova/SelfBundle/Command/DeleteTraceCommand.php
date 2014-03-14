<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteTraceCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:delete:trace')
            ->setDescription('Delete trace SELF')
            ->addArgument('name')
           ;
    }

    /**
     * If I have any data in database, then I don't execute fixtures. EV.
     *
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        $name = $input->getArgument('name');
        if ($name != 'sql') {
            $output->writeln("Absence de paramètres. Impossible d'exécuter les requêtes.");
            exit;
        }

        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        $output->writeln("Suppression ANSWER ...");
        $answers = $em->getRepository('InnovaSelfBundle:Answer')->findAll();
        foreach ($answers as $answer) {
            $em->remove($answer);
        }

        $output->writeln("Suppression TRACE ...");
        $traces = $em->getRepository('InnovaSelfBundle:Trace')->findAll();
        foreach ($traces as $trace) {
            $em->remove($trace);
        }

        $em->flush();

    }

}
