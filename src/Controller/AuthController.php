<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/registration', name: 'registration')]
    public function userRegistration(Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('/account/?????');
        }

        return $this->render('Registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}