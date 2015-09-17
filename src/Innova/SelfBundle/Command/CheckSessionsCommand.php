<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckSessionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
          ->setName('self:sessions:check')
          ->setDescription('Checks user activity for the past couple of minutes and prints out some stats');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = $this->getHelperSet()->get('table');
        $table->setHeaders(array('#', 'User', 'Admin'));

        $total_active_auth_count = 0;

        $connectedUsers = $this->getContainer()->get('self.user.manager')->getConnected();
        foreach ($connectedUsers as $connectedUser) {
            $total_active_auth_count++;
            $table->addRow(array($total_active_auth_count, $connectedUser[0], $connectedUser[1]));
        }

        $table->render($output);

        $output->writeln(sprintf(
            '<info>%s logged in user(s) in the lasts 300 seconds.',
            $total_active_auth_count
        ));
    }
}
