<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\User;
use App\Exception\ParameterNotFoundException;
use App\Message\Error\UserError;
use App\Message\Success\UserSuccess;

class AuthenticationController extends AbstractController
{
    /**
     * @Route("/register", name="register")
     */
    public function register(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse {
        $requestBody = $request->request->all();
        //
        $firstName = $this->getRequiredParameter(
            "firstName",
            $requestBody,
            UserError::FIRST_NAME_REQUIRED
        );
        $lastName = $this->getRequiredParameter(
            "lastName",
            $requestBody,
            UserError::LAST_NAME_REQUIRED
        );
        $email = $this->getRequiredParameter(
            "email",
            $requestBody,
            UserError::EMAIL_REQUIRED
        );
        $password = $this->getRequiredParameter(
            "password",
            $requestBody,
            UserError::PASSWORD_REQUIRED
        );

        $name = $requestBody["name"] ?? "{$firstName} {$lastName}";
        $user = new User($firstName, $lastName, $email, $name);
        $hashedPassword = $passwordHasher->hashPassword($user, $password);
        $user->setPassword($hashedPassword);

        $em->persist($user);
        $em->flush();

        return $this->json(
            ["message" => UserSuccess::REGISTER_SUCCESS],
            Response::HTTP_CREATED
        );
    }

    private function getRequiredParameter(
        string $parameterName,
        array $requestBody,
        string $errorMessage
    ) {
        if (!isset($requestBody[$parameterName])) {
            throw new ParameterNotFoundException($errorMessage);
        }
        return $requestBody[$parameterName];
    }
}
