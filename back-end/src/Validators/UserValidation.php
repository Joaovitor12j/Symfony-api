<?php

namespace App\Validators;

use App\Entity\User;
use App\Exception\HandleUserException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserValidation
{
    private ?User $userData;
    private ?string $userPassword;
    private UserPasswordHasherInterface $passwordEncoder;

    public function __construct(?User $userData, ?string $userPassword, UserPasswordHasherInterface $passwordEncoder)
    {
        $this->userData = $userData;
        $this->userPassword = $userPassword;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @throws HandleUserException
     */
    public function validateUserEmail(): void
    {
        if (! $this->userData) {
            throw new HandleUserException('Usuário não encontrado', 401);
        }
    }

    /**
     * @throws HandleUserException
     */
    public function validateUserPassword(): void
    {
        if (! $this->passwordEncoder->isPasswordValid($this->userData, $this->userPassword)) {
            throw new HandleUserException('A senha informada está incorreta', 401);
        }
    }

    /**
     * @throws HandleUserException
     */
    public function validateEmailExists(): void
    {
        if ($this->userData) {
            throw new HandleUserException('Esse email já está cadastrado, faça login ou informe outro email', 422);
        }
    }
}