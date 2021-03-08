<?php

declare(strict_types=1);

namespace App\Api\Controller\Http\UserAccess;

use App\UserAccess\UseCase\SignUp\SignUpCommand;
use App\UserAccess\UseCase\SignUp\SignUpHandler;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SignUp
{
    /**
     * @var SignUpHandler
     */
    private SignUpHandler $signUpHandler;

    /**
     * @param SignUpHandler $signUpHandler
     */
    public function __construct(SignUpHandler $signUpHandler)
    {
        $this->signUpHandler = $signUpHandler;
    }

    /**
     * @Route(
     *     "sign-up",
     *     name="sign-up",
     *     methods={"POST"}
     * )
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $readModel = $this->signUpHandler->handle(
            new SignUpCommand(
                $request->get('login', ''),
                $request->get('email', ''),
                $request->get('password', ''),
                $request->get('role', '')
            ));

        $responseContent = [
            'user' =>
                [
                    'login' => $readModel->getLogin(),
                    'email' => $readModel->getEmail(),
                    'role' => $readModel->getRole(),
                    'temporaryToken' => $readModel->getTemporaryToken(),
                ]
        ];

        return new JsonResponse($responseContent, JsonResponse::HTTP_OK);
    }

}