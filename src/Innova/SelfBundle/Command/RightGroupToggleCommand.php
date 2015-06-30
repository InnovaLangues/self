<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class RightGroupToggleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:rightGroup:toggle')
            ->setDescription('Toggle les droits pour un groupe de droits donnés et un utilisateur.')
            ->addArgument('username', InputArgument::REQUIRED, 'username')
            ->addArgument('rightgroupname', InputArgument::REQUIRED, 'nom du groupe (rightgroup.tasks, rightgroup.tests, rightgroup.sessions, rightgroup.groups, rightgroup.users, rightgroup.exports)')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $username = $input->getArgument('username');
        $rightGroupName = $input->getArgument('rightgroupname');

        $user = $em->getRepository('InnovaSelfBundle:User')->findOneByUsername($username);
        $rightGroup = $em->getRepository("InnovaSelfBundle:Right\RightGroup")->findOneByName($rightGroupName);

        $this->getContainer()->get("self.rightgroup.manager")->toggleAll($user, $rightGroup);

        $output->writeln("Toggle !");
    }
}
