<?php

namespace IMSExport\Application\IMS\Services\Formats;

use IMSExport\Application\XMLGenerator\Generator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ZipArchive;

abstract class BaseFormat implements Format
{
    const PATH = './storage/export/IMS/';

    public Generator $XMLGenerator;

    public function __construct()
    {
        $this->XMLGenerator = new Generator();
        $this->createDirectory()
            ->XMLGenerator
            ->init($this->getFullPath());
    }

    public function createDirectory(): self
    {
        $x = mkdir(
            self::PATH . $this->getFolderName(),
            0777,
            true
        );
        print_r($x);
        print_r("Creando archivaldo");
        return $this;
    }

    protected function getFullPath(): string
    {
        return self::PATH . "{$this->getFolderName()}/{$this->getName()}";
    }

    function zip($source, $destination)
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }

        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }

        $source = str_replace('\\', '/', realpath($source));

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);

            foreach ($files as $file) {
                $file = str_replace('\\', '/', $file);

                // Ignore "." and ".." folders
                if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                    continue;

                $file = realpath($file);

                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                } else if (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                }
            }
        } else if (is_file($source) === true) {
            $zip->addFromString(basename($source), file_get_contents($source));
        }

        return $zip->close();
    }

    protected function finish(): self
    {
        $this->XMLGenerator->finish();
        $this->zip(self::PATH . $this->getFolderName(), self::PATH.$this->getName().'.zip');
        return $this;
    }
}