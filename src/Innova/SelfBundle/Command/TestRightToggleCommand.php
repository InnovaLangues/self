<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class TestRightToggleCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:righttest:toggle')
            ->setDescription('Toggle les droits pour un test et un utilisateur donné.')
            ->addArgument('username', InputArgument::REQUIRED, 'username')
            ->addArgument('testId', InputArgument::REQUIRED, 'id du test')
            ->addArgument('giveRight', InputArgument::REQUIRED, '0 or 1, depending if you wanna give or remove rights')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $username = $input->getArgument('username');
        $testId = $input->getArgument('testId');
        $giveRight = $input->getArgument('giveRight');

        $user = $em->getRepository('InnovaSelfBundle:User')->findOneByUsername($username);
        $test = $em->getRepository("InnovaSelfBundle:Test")->findOneById($testId);

        if ($this->getContainer()->get("self.righttest.manager")->toggleAll($user, $test, $giveRight)) {
            $output->writeln("Des droits on été ajoutés !");
        } else {
            $output->writeln("Des droits on été retirés !");
        }
    }
}
