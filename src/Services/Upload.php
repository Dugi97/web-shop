<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 27.10.18.
 * Time: 10.23
 */

namespace App\Services;

use App\Model\iUpload;
use Gumlet\ImageResize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\Security;

class Upload implements iUpload
{
    public function upload(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(__DIR__.'/../../public/upload', $fileName);
        return $fileName;
    }

    public function uploadAvatar(UploadedFile $file)
    {
        $fileName = $file->getClientOriginalName();
        $file->move(__DIR__.'/../../public/profile', $fileName);
        return $fileName;
    }

    public function multiUpload($files)
    {
        $error = 'error';

        $images = [];
        if (!empty($files['files']['name'][0])) {
            if (in_array(1,$files['files']['error'])) {
                return $error;
            } else {
                foreach ($files['files']['tmp_name'] as $index => $file) {
                    $array = explode('/', $file);
                    $expression = explode('/', $files['files']['type'][$index]);
                    $fileName = explode('/', $file);

                    $imageSmall = new ImageResize($file);
                    $imageMedium = new ImageResize($file);

                    $imageSmall->resizeToBestFit(100, 100);
                    $imageMedium->resizeToBestFit(800, 800);

                    $imageSmall->save(__DIR__.'/../../public/products/images/alias/small/' . end($array) . '.' . end($expression));
                    $imageMedium->save(__DIR__.'/../../public/products/images/alias/medium/' . end($array) . '.' . end($expression));

                    $images[] = end($fileName) .'.'.$expression[1];
                }
                return $images;
            }
        } else {
            return $images;
        }
    }
}