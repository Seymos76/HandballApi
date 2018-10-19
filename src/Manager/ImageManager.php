<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 21:17
 */

namespace App\Manager;


use App\Entity\Galery;
use App\Entity\Gallery;
use App\Entity\Image;
use App\Entity\Slide;
use App\Service\Image\Uploader;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageManager extends EntityManager
{
    protected $container;
    protected $uploader;

    public function __construct(EntityManagerInterface $manager, ContainerInterface $container, Uploader $uploader)
    {
        parent::__construct($manager);
        $this->container = $container;
        $this->uploader = $uploader;
    }

    public function createImage(UploadedFile $file)
    {
        /** @var Image $image */
        $image = new Image();
        $image->setExtension($file->guessExtension());
        $image->setMimeType($file->getMimeType());
        $image->setSize($file->getSize());
        $this->update($image);
        return $image;
    }

    public function uploadFile(UploadedFile $file, string $targetDir, string $filename = null)
    {
        $filename = $this->uploader->upload($file, $targetDir, $filename);
        return $filename;
    }

    public function addImageOnGallery(Gallery $gallery, string $filename)
    {
        $image = $this->getManager()->getRepository(Image::class)->findOneBy(
            array(
                'filename' => $filename
            )
        );
        if (null === $image || !$image instanceof Image) {
            return;
        }
        $gallery->addImage($image);
        $this->persist($gallery);
        return $gallery;
    }

    public function removeImageFromApp(Image $image, string $targetDirectory)
    {
        $current_image = $targetDirectory.$image->getFilename();
        if (null === $current_image) {
            return;
        }
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

    public function removeFolder(string $folder)
    {
        if (is_dir($folder)) {
            rmdir($folder);
            return true;
        } else {
            return false;
        }
    }
}