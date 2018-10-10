<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 21:17
 */

namespace App\Manager;


use App\Entity\Galery;
use App\Entity\Image;
use App\Entity\Slide;
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
        $image->setFilename($this->uploader->generateFileName().".".$file->guessExtension());
        $image->setExtension($file->guessExtension());
        $image->setMimeType($file->getMimeType());
        $image->setSize($file->getSize());
        dump($image);
        die;
        $this->update($image);
        return $image->getFilename();
    }

    public function uploadFile(UploadedFile $file, string $filename, string $targetDir)
    {
        $this->uploader->upload($file, $filename, $targetDir);
    }

    public function addImageOnGallery(Galery $galery, string $filename)
    {
        $image = $this->getManager()->getRepository(Image::class)->findOneBy(
            array(
                'filename' => $filename
            )
        );
        if (null === $image || !$image instanceof Image) {
            return;
        }
        $galery->addImage($image);
        $this->persist($galery);
        return $galery;
    }

    public function removeImageFromApp(Image $image)
    {
        $current_image = $this->container->getParameter('hb.galery_image')."/".$image->getFilename().".".$image->getExtension();
        if (null === $current_image) {
            return;
        }
        $this->remove($image);
        self::deleteFile($current_image);
        return true;
    }

    /**
     * @param $file
     * @return bool
     */
    public function deleteFile($file)
    {
        if (file_exists($file)) {
            unlink($file);
            return true;
        } else {
            return false;
        }
    }

    public function validateImageAndGallery(Galery $galery, Image $image)
    {
        if (!$galery instanceof Galery || null === $galery) {
            return;
        }
        if (!$image instanceof Image || null === $image) {
            return;
        }
        return true;
    }
}