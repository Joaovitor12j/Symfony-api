<?php

namespace App\Validators;

use App\Entity\User;
use App\Exception\HandleUserException;
use Symfony\Component\HttpFoundation\Response;
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
        $this->throwIf(!$this->userData, 'Usuário não encontrado', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws HandleUserException
     */
    public function validateUserPassword(): void
    {
        $isValid = $this->userData && $this->passwordEncoder->isPasswordValid($this->userData, $this->userPassword);
        $this->throwIf(!$isValid, 'Credenciais inválidas', Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @throws HandleUserException
     */
    public function validateEmailExists(): void
    {
        $this->throwIf($this->userData->getEmail(), 'Esse email já está cadastrado, faça login ou informe outro email',
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }

    /**
     * @throws HandleUserException
     */
    private function throwIf(bool $condition, string $message, int $code): void
    {
        if ($condition) {
            throw new HandleUserException($message, $code);
        }
    }
}