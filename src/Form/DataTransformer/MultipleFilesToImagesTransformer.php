<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 18:45
 */

namespace App\Form\DataTransformer;

use App\Entity\Image;
use App\Manager\ImageManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MultipleFilesToImagesTransformer implements DataTransformerInterface
{
    private $manager;
    private $imageManager;
    private $container;

    public function __construct(EntityManagerInterface $manager, ImageManager $imageManager, ContainerInterface $container)
    {
        $this->manager = $manager;
        $this->imageManager = $imageManager;
        $this->container = $container;
    }

    public function transform($images)
    {
        if (!$images) {
            return;
        }
        $files = [];
        foreach ($images as $image) {
            $files[] = $image->getFilename() . "." . $image->getExtension();
        }
        return $files;
    }

    public function reverseTransform($files)
    {
        if (!$files) {
            return;
        }
        $filenames = [];
        foreach ($files as $file) {
            dump($file);
            //$filename = $this->imageManager->createImage($file);
            //$this->imageManager->uploadFile($file, $filename, $this->container->getParameter('hb.galery_image'));
            //array_push($filenames, $filename);
        }
        die;
        $images = [];
        foreach ($filenames as $filename) {
            $image = $this->imageManager->getManager()->getRepository(Image::class)->findOneBy(
                array(
                    'filename' => $filename
                )
            );
            if (null === $image) {
                throw new TransformationFailedException(sprintf('Image with "%s" does not exist...', $image));
            }
            array_push($images, $image);
        }
        return $images;
    }
}