<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Services\Helper;
use App\Services\Mail;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ForgotPasswordController extends Controller
{
    /**
     * @Route("/forgot/password", name="forgot_password")
     */
    public function forgot(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder, Mail $mail)
    {
        $form = $this->createFormBuilder()
            ->add('email', EmailType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-dark border rounded-0'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $em->getRepository(User::class)->findOneBy(['email' => $form['email']->getData()]);
            $code = Helper::randomCode();

            $user->setPassword($encoder->encodePassword(new User(), $code));
            $em->persist($user);
            $em->flush();

            $mail->sendMail($form['email']->getData(), 'New password', $this->renderView('emails/forgot_password.html.twig',
                [
                    'pass' => $code
                ]
            ));

            return $this->redirectToRoute('login');
        }

        return $this->render('security/forgot/forgot_password.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}