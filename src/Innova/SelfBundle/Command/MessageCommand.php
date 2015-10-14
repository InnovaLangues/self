<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class MessageCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:message')
            ->setDescription('Envoie un message')
            ->addArgument('channel', InputArgument::REQUIRED, 'all or admin')
            ->addArgument('message', InputArgument::REQUIRED, 'message you want to send')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $channel = $input->getArgument('channel');
        $message = $input->getArgument('message');

        if ($this->getContainer()->get("self.message.manager")->sendMessage($message, $channel)) {
            $output->writeln("Le message a bien été envoyé");
        };
    }
}
