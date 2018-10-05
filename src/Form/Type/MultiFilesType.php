<?php
/**
 * Created by PhpStorm.
 * User: seymos
 * Date: 05/10/18
 * Time: 18:30
 */

namespace App\Form\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MultiFilesType extends AbstractType
{
    public function getParent()
    {
        return FileType::class;
    }
}