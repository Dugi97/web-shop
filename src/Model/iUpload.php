<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 2.1.19.
 * Time: 17.32
 */

namespace App\Model;


use Symfony\Component\HttpFoundation\File\UploadedFile;

interface iUpload
{
    /**
     * This method serves for upload profile image. Upload destination is public/profile.
     *
     * @param $file
     * @return mixed
     */
    public function uploadAvatar(UploadedFile $file);

    /**
     * This method serves for upload any files. Upload destination is public/upload.
     *
     * @param UploadedFile $file
     * @return mixed
     */
    public function upload(UploadedFile $file);

    /**
     * This method serves for multi image upload.
     *
     * @param $files
     * @return mixed
     */
    public function multiUpload($files);
}