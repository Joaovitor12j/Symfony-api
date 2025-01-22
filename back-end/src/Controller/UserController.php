<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
    #[Route('/user', name: 'app_user')]
    public function index(Request $request): JsonResponse
    {
        $session = $request->getSession();

        $userName = $session->get('nome');
        $userEmail = $session->get('email');
        $userId = $session->get('usuario_id');

        return new JsonResponse([
            'message' => 'Seja bem vindo, ' . $userName . '!',
            'nome' => $userName,
            'email' => $userEmail,
            'usuario_id' => $userId,
        ]);
    }

    #[Route('/register', methods: ['POST'])]
    public function register(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setName($data['nome']);
        $user->setEmail($data['email']);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $data['senha']));
        $user->setCreateAt(new DateTime());

        $em->persist($user);
        $em->flush();

        return new JsonResponse(['message' => 'Usuário criado com sucesso!'], 201);
    }

    #[Route('/login', methods: ['GET'])]
    public function login(Request $request): JsonResponse
    {
        $userEmail = $request->query->get('email');
        $userPassword = $request->query->get('senha');

        $user = $this->userRepository->findByEmail($userEmail);

        if (!$user || !$this->passwordEncoder->isPasswordValid($user, $userPassword)) {
            return new JsonResponse(['mensagem' => 'Senha ou email incorreto'], 401);
        }

        $session = $request->getSession();
        $session->set('usuario_id', $user->getId());
        $session->set('nome', $user->getName());
        $session->set('email', $user->getEmail());

        return new JsonResponse(['mensagem' => 'Logado com sucesso!']);
    }

}
