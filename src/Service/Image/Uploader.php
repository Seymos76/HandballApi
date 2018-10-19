<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 04/10/18
 * Time: 21:14
 */

namespace App\Service\Image;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    public function upload(UploadedFile $file, $targetDirectory, string $filename = null)
    {
        $filename = self::generateFileName().".".$file->guessExtension();
        $file->move(
            $targetDirectory,
            $filename
        );
        return $filename;
    }

    public function generateFileName()
    {
        return uniqid();
    }
}