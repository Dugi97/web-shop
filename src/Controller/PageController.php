<?php
/**
 * Created by PhpStorm.
 * User: kule
 * Date: 17.12.18.
 * Time: 17.50
 */

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    /**
     * @Route("/about-us", name="about_us")
     */
    public function aboutUs()
    {
        return $this->render('default/pages/about_us.html.twig');
    }

    /**
     * @Route("/contact-us", name="contact_us")
     */
    public function contactUs()
    {
        return $this->render('default/pages/contact_us.html.twig');
    }

    /**
     * @Route("/faq", name="faq")
     */
    public function faq()
    {
        return $this->render('default/pages/faq.html.twig');
    }

    /**
     * @Route("/delivery", name="delivery")
     */
    public function delivery()
    {
        return $this->render('default/pages/delivery.html.twig');
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function payment()
    {
        return $this->render('default/pages/payment.html.twig');
    }
}