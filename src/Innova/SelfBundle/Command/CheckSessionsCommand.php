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
        $threshold = 300; // Maximum seconds for last activity
        $limit = time() - $threshold;

        $em = $this->getContainer()->get('doctrine.orm.entity_manager');

        $dql = 'select s from InnovaSelfBundle:PDOSession s
            where s.session_time >= ?1
            order by s.session_time desc';
        $query = $em->createQuery($dql);
        $query->setParameter(1, $limit);
        $sessions = $query->getResult();

        $total_active_count = count($sessions); // Total active users
        $total_active_auth_count = 0;           // Total active logged in users

        foreach ($sessions as $session) {
            $data = base64_decode($session->getSessionValue());
            $data = str_replace('_sf2_attributes|', '', $data);
            $data = unserialize($data);

            // If this is a session belonging to an anonymous user, do nothing
            if (!array_key_exists('_security_main', $data)) {
                continue;
            }

            // User is logged in, increment counter
            $total_active_auth_count++;

            // Grab security data
            $data = $data['_security_main'];
            $data = unserialize($data);
        }

        $output->writeln(sprintf(
            '<info><error>%s</error> user(s) were active in the last %s seconds, and <error>%s</error> of them was/were logged in.</info>',
            $total_active_count,
            $threshold,
            $total_active_auth_count
        ));
    }
}
