<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 22:21
 */

namespace App\Form\DataTransformer;


use App\Entity\Image;
use App\Manager\ImageManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FileToImageTransformer implements DataTransformerInterface
{
    private $manager;
    private $imageManager;
    private $session;

    public function __construct(EntityManagerInterface $manager, ImageManager $imageManager, SessionInterface $session)
    {
        $this->manager = $manager;
        $this->imageManager = $imageManager;
        $this->session = $session;
    }

    /**
     * Transform an Image to a string
     * @param Image|null $image
     * @return string
     */
    public function transform($image)
    {
        if ($image === null) {
            return "";
        }
        return $image->getFilename();
    }

    /**
     * @param UploadedFile $file
     * @return Image
     */
    public function reverseTransform($file)
    {
        if (!$file) {
            return;
        }
        $filename = $this->imageManager->createImage($file);
        if (!$filename) {
            return;
        }
        $image = $this->manager->getRepository(Image::class)->findOneBy(
            array(
                'filename' => $filename
            )
        );
        if (null === $image) {
            throw new TransformationFailedException(sprintf('Image with "%s" does not exist...', $image));
        }
        return $image;
    }
}