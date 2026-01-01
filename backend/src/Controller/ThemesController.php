<?php

namespace App\Controller;

use App\Repository\ThemeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ThemesController extends AbstractController
{
    #[Route('/api/themes', name: 'api_themes', methods: ['GET'])]
    public function index(ThemeRepository $themeRepository): JsonResponse
    {
        $themes = $themeRepository->findAll();

        $data = array_map(function($theme) {
            return [
                'id' => $theme->getId(),
                'name' => $theme->getName(),
                'backgroundImage' => $theme->getBackgroundImage(),
                'primaryColor' => $theme->getPrimaryColor(),
                'secondaryColor' => $theme->getSecondaryColor(),
                'musicUrl' => $theme->getMusicUrl(),
                'videoUrl' => $theme->getVideoUrl(),
                'description' => $theme->getDescription(),
            ];
        }, $themes);

        return $this->json($data);
    }
}