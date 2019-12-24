<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 27.10.18.
 * Time: 10.23
 */

namespace App\Services;


use App\Model\iMail;
use Swift_Mailer;
use Swift_Message;

class Mail implements iMail
{
    private $mailer;

    public function __construct($mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($email, $subject, $message)
    {
        $message = (new Swift_Message($subject))
            ->setFrom('info@webshop.com')
            ->setTo($email)
            ->setBody($message,'text/html');

        return $this->mailer->send($message);
    }
}