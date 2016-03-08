<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

class CheckTracesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:check:traces')
            ->setDescription('Delete duplicate in traces')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');

        if ($traces = $em->getRepository('InnovaSelfBundle:Trace')->findDuplicate()) {
            $question = new ConfirmationQuestion(count($traces).' trace(s) will be deleted. Continue with this action?', false);
            if (!$helper->ask($input, $output, $question)) {
                $output->writeln('Duplicate traces have not been deleted.');

                return;
            }

            foreach ($traces as $trace) {
                $em->remove($trace);
            }
            $output->writeln('Duplicate traces have been deleted.');
            $em->flush();

            return;
        };

        $output->writeln('No duplicate traces found.');

        return;
    }
}
