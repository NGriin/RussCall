<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AuthController extends AbstractController
{
    #[Route('/registration', name: 'registration')]
    public function userRegistration(Request $request, EntityManagerInterface $em, UserRepository $userRepository): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingUser = $userRepository->findOneBy(['userName' => $user->getUsername()]);
            $existingUserEmail = $userRepository->findOneBy(['email' => $user->getEmail()]);

            if ($existingUser) {
                $form->addError(new FormError('Пользователь с таким именем уже существует.'));
            }

            if ($existingUserEmail) {
                $form->addError(new FormError('Пользователь с таким email уже существует.'));
            }

            if ($form->getErrors()->count() > 0) {
                return $this->render('Registration/register.html.twig', [
                    'registrationForm' => $form->createView(),
                ]);
            }

            $user->setPassword(password_hash($user->getPassword(), PASSWORD_BCRYPT));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('account');
        }

        return $this->render('Registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}