<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class GitterMessageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:gitter')
            ->setDescription('Toggle les droits pour un groupe de droits donnés et un utilisateur.')
            ->addArgument('message', InputArgument::REQUIRED, 'message')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $message = $input->getArgument('message');
        $this->getContainer()->get('innova_gitter.manager')->sendMessage($message);

        $output->writeln("Message envoyé !");
    }
}
