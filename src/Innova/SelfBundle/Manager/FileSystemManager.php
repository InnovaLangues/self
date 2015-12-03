<?php

namespace Innova\SelfBundle\Manager;

use Symfony\Component\Filesystem\Filesystem;

class FileSystemManager
{
    protected $publicFileSystem;
    protected $privateFileSystem;
    protected $kernelRoot;

    public function __construct($publicFileSystem, $privateFileSystem, $kernelRoot)
    {
        $this->publicFileSystem = $publicFileSystem;
        $this->privateFileSystem = $privateFileSystem;
        $this->kernelRoot = $kernelRoot;
    }

    private function getAdapter($acl)
    {
        $fileSystem = ($acl == 'public')
            ? $this->publicFileSystem
            : $this->privateFileSystem;

        return $fileSystem->getAdapter();
    }

    public function getFile($acl, $fileName)
    {
        $adapter = $this->getAdapter($acl);
        $file = $adapter->read($fileName);

        $path = $this->createLocalFile($file, $fileName);

        return $path;
    }

    public function writeFile($acl, $fileName, $file)
    {
        $adapter = $this->getAdapter($acl);
        $adapter->write($fileName, $file);

        return $file;
    }

    private function createLocalFile($fileContent, $filename)
    {
        $fs = new Filesystem();
        $pdfPathExport = $this->kernelRoot.'/data/'.uniqid().'/';
        $fs->mkdir($pdfPathExport, 0777);

        $fileName = 'self_export-'.date('d-m-Y_H:i:s').'.csv';

        //$fileName = $pdfPathExport.$name;

        $localFilePath = $pdfPathExport.'/'.$fileName;
        $f = fopen($localFilePath, 'w+');
        fwrite($f, $fileContent);
        fclose($f);

        return $localFilePath;
    }
}
