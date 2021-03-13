<?php


namespace App\Services;


use Psr\Container\ContainerInterface;

class CreateFileServices
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function fileMap($file, $name, $path)
    {
        $path = str_replace("\\", "/", $path)."";
        $newName = $name . "" . rand() . "." . $file->guessExtension();
        $file->move($path, $newName);
        $newPath = $path . "" . $newName;
        return $newPath;
    }
}
