<?php

namespace Innova\SelfBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;

class DeleteMediaFileCommand extends ContainerAwareCommand
{

    protected function configure()
    {
        $this
            ->setName('self:delete:files')
            ->setDescription('Delete unused media files')
            ->addArgument('name')
           ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine')->getEntityManager('default');
        $mediaDir = $this->getContainer()->get('kernel')->getRootDir()."/../web/upload/media/";
        $dialog = $this->getHelper('dialog');

        $finder = new Finder();
        $finder->files()->in($mediaDir);
        $orphanFiles = array();

        foreach ($finder as $file) {
            $fileName =  $file->getRelativePathname();

            if(!$em->getRepository('InnovaSelfBundle:Media\Media')->findOneByUrl($fileName)){
                $orphanFiles[] = $fileName;
            }
        }
        $output->writeln("\nchecking <info>".$mediaDir."</info>");
        $output->writeln("<info>".count($finder)."</info> file(s) found including <error>".count($orphanFiles)."</error> orphan(s)\n");

        if (!empty($orphanFiles) && !$dialog->askConfirmation($output,'<question>Do you want to definitely delete them ?</question>',false)) {
            return;
        }

        foreach ($orphanFiles as $orphan) {
            unlink($mediaDir.$orphan);
        }
    }

}
