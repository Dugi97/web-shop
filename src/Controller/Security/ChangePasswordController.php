<?php

namespace App\Controller\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangePasswordController extends Controller
{
    /**
     * @Route("/change/password", name="change_password")
     */
    public function index(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $form = $this->createFormBuilder()
            ->add('current', PasswordType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-dark border rounded-0'
                ]
            ])
            ->add('new', PasswordType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control border-dark border rounded-0'
                ]
            ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $isPasswordValid = $encoder->isPasswordValid($this->getUser(), $form['current']->getData());

            if ($isPasswordValid) {
                $new = $encoder->encodePassword(new User(), $form['new']->getData());
                $this->getUser()->setPassword($new);
                $em->persist($this->getUser());
                $em->flush();
            }

            return $this->redirectToRoute('login');
        }

        return $this->render('security/change/change_password.html.twig',
            [
                'form' => $form->createView()
            ]
        );
    }
}
