<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class SelfRegistrationCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('self:selfregistration')
            ->setDescription('Active ou désactive l\'auto-inscription')
            ->addArgument('enabled', InputArgument::REQUIRED, '0 or 1, depending if you wanna enable or disable it')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getManager('default');

        $enabled = $input->getArgument('enabled');

        if ($this->getContainer()->get("self.generalparams.manager")->setSelfRegistration($enabled)) {
            $output->writeln("L'auto-inscription est activée");
        } else {
            $output->writeln("L'auto-inscription est désactivée");
        }
    }
}
