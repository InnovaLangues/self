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

    public function listFiles($acl, $dir)
    {
        $adapter = $this->getAdapter($acl);
        $files = $adapter->listKeys($dir);
        $fileNames = array();
        foreach ($files as $file) {
            $fileNames[] = basename($file);
        }

        return $fileNames;
    }

    private function createLocalFile($fileContent, $filename)
    {
        $fs = new Filesystem();
        $pdfPathExport = $this->kernelRoot.'/data/tmp/';
        $localFilePath = $pdfPathExport.$filename;
        $fs->dumpFile($localFilePath, $fileContent);

        return $localFilePath;
    }
}
