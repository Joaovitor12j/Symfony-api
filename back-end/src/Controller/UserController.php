<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\HandleUserException;
use App\Repository\UserRepository;
use App\Validators\UserValidation;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userRepository = $userRepository;
        $this->passwordEncoder = $passwordEncoder;
    }
    #[Route('/user', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $session = $request->getSession();

        $userName = $session->get('name');
        $userEmail = $session->get('email');

        if (! $userName || ! $userEmail) {
            return new JsonResponse([
                'mensagem' => 'Usuário não autenticado.'
            ], 401);
        }

        return new JsonResponse([
            'name' => $userName,
            'email' => $userEmail
        ]);
    }

    /**
     * @throws HandleUserException
     */
    #[Route('/register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = $this->userRepository->findOneByEmail($data['email']);

        $userValidation = new UserValidation($user, '', $this->passwordEncoder);
        $userValidation->validateEmailExists();

        $user = new User();
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['password']));
        $user->setCreatedAt(new DateTime());

        $em->persist($user);
        $em->flush();

        $session = $request->getSession();
        $session->set('name', $user->getName());
        $session->set('email', $user->getEmail());

        return new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], Response::HTTP_CREATED);
    }

    /**
     * @throws HandleUserException
     */
    #[Route('/login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userEmail = $data['email'] ?? null;
        $userPassword = $data['password'] ?? null;

        $user = $this->userRepository->findOneByEmail($userEmail);

        $userValidation = new UserValidation($user, $userPassword, $this->passwordEncoder);
        $userValidation->validateUserEmail();
        $userValidation->validateUserPassword();

        $session = $request->getSession();
        $session->set('name', $user->getName());
        $session->set('email', $user->getEmail());

        return new JsonResponse([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ], Response::HTTP_OK);

    }

    #[Route('/logout', methods: ['POST'])]
    public function logout(Request $request): JsonResponse
    {
        $session = $request->getSession();
        $session->invalidate();

        return new JsonResponse('', Response::HTTP_NO_CONTENT);
    }

}
