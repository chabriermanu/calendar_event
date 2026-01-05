<?php

namespace App\DTO\Response;

/**
 * DTO pour la réponse de l'endpoint /api/me
 * Représente les informations de base d'un utilisateur connecté
 */
class UserMeResponse
{
    public int $id;
    public string $pseudo;
    public int $age;
    public string $avatar;
    public array $roles;

    // Pas besoin de getters/setters, propriétés publiques suffisent pour un DTO
    // Le JsonResponse de Symfony va sérialiser automatiquement
    // DTO = classe simple, données uniquement
    // Pas de logique métier
    // Pas d'annotations Doctrine
    // Propriétés publiques (pas de getters/setters nécessaires)
    
}