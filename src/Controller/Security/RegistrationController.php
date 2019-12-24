<?php

namespace App\Controller\Security;

use App\Form\UserType;
use App\Entity\User;
use App\Controller\Security\LoginController;
use App\Services\Mail;
use App\Services\Upload;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $em, Mail $mail, Upload $upload)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordEncoder->encodePassword($user, $user->getPlainPassword()));
            $user->setActivationHash(sha1(md5("58rtE".$passwordEncoder->encodePassword($user, $user->getPlainPassword())."jjJ789%R")));
            $user->setAvatar($user->getFile() ? $upload->uploadAvatar($user->getFile()) : 'no-image.png');
            $em->persist($user);
            $em->flush();

            $mail->sendMail($user->getEmail(), 'Symfony 4 activation mail', $this->renderView('emails/activation.html.twig',
                [
                    'name' => $user->getName(),
                    'lastName' => $user->getLastName(),
                    'activationLink' => $user->getActivationHash()
                ]
            ));

            return $this->render('security/registration/confirmation.html.twig');
        }

        return $this->render('security/registration/register.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/account/verification/{hash}", name="account_verification")
     */
    public function accountVerification(EntityManagerInterface $em, $hash)
    {
        $repository = $em->getRepository(User::class)->findOneBy(['activationHash' => $hash]);

        $repository->setIsActive(true);
        $em->persist($repository);
        $em->flush();

        return $this->render('security/login/account_verification.html.twig',
            [
                'name' => $repository->getName(),
                'lastName' => $repository->getLastName()
            ]
        );
    }
}