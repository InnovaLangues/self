<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

class LogSessionsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
          ->setName('self:sessions:log')
          ->setDescription('Write number of connected in users.log');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $log = new Logger('connected');
        $handler = new StreamHandler('./app/logs/users.log');
        $handler->setFormatter(new LineFormatter("[%datetime%] %channel%.%level_name%: %message%\n"));
        $log->pushHandler($handler);
        $connectedUsers = count($this->getContainer()->get('self.user.manager')->getConnected());
        $log->addInfo($connectedUsers);
    }
}
