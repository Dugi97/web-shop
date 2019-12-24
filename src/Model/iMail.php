<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 2.1.19.
 * Time: 17.10
 */

namespace App\Model;


interface iMail
{
    /**
     * @param string $email Expected email address
     * @param string $subject Expected string (title)
     * @param string $message Expected message
     * @return mixed
     */
    public function sendMail($email, $subject, $message);
}