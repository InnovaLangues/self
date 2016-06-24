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
        $table->setHeaders(array('#', 'User', 'Nom', 'Prénom', 'Etablissement', 'Mail', 'Admin'));

        $total_active_auth_count = 0;

        $connectedUsers = $this->getContainer()->get('self.user.manager')->getConnected();
        foreach ($connectedUsers as $user) {
            ++$total_active_auth_count;
            $admin = in_array('ROLE_SUPER_ADMIN', $user->getRoles()) ? 'X' : '';
            $institution = ($user->getInstitution()) ? $user->getInstitution()->getName() : '';
            $username = $user->getUsername();
            $firstname = $user->getFirstName();
            $lastname = $user->getLastName();
            $mail = $user->getEmail();

            $table->addRow(array($total_active_auth_count, $username, $firstname, $lastname, $institution, $mail, $admin));
        }

        $table->render($output);

        $output->writeln(sprintf(
            '<info>%s logged in user(s) in the lasts 300 seconds.',
            $total_active_auth_count
        ));
    }
}
