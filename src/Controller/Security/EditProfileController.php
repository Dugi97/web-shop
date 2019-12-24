<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\User\UserInterface;

class EditProfileController extends Controller
{
    /**
     * @Route("/edit/profile", name="edit_profile")
     */
    public function index(Request $request, UserInterface $user)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->find($user->getId());

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute($this->getUser()->getRole() === 'ROLE_SUPER_ADMIN' ? 'admin' : 'home');
        }

        return $this->render('security/edit/edit_profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
