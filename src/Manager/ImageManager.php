<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 21:17
 */

namespace App\Manager;


use App\Entity\Image;
use App\Service\Image\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager extends EntityManager
{
    private $container;
    private $uploader;

    public function __construct(EntityManagerInterface $manager, ContainerInterface $container, Uploader $uploader)
    {
        parent::__construct($manager);
        $this->container = $container;
        $this->uploader = $uploader;
    }

    public function createImage(UploadedFile $file)
    {
        $image = new Image();
        $image->setFilename(self::getUniqueName());
        $image->setExtension($file->guessExtension());
        $image->setMimeType($file->getMimeType());
        $image->setPath($this->container->getParameter('hb.player_image'));
        $image->setSize($file->getSize());
        $this->uploader->upload($file, $image->getFilename(), $image->getPath());
        $this->update($image);
        return $image->getFilename();
    }

    public function getUniqueName(): ?string
    {
        return $unique = md5(uniqid());
    }
}