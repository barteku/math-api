<?php

namespace App\Controller;

use App\Request\ApiRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{

    #[Route('/api', name: 'app_api', methods: ['GET'])]
    public function index(ApiRequest $request): JsonResponse
    {
        $request->validate();

        return $this->json([
            'value' => $request->calculateValue()
        ]);
    }
}
