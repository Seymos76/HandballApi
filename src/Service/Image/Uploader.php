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
    public function upload(UploadedFile $file, string $filename, $targetDirectory)
    {
        $file_name = $filename . "." . $file->guessExtension();
        $file->move(
            $targetDirectory,
            $file_name
        );
        return $file_name;
    }
}