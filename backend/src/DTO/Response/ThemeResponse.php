<?php

namespace App\DTO\Response;

/**
 * DTO pour représenter un thème de Noël
 * Utilisé dans FamilleProfileResponse
 */

class ThemeResponse

{
 
    public int $id;
    public string $name;
    public string $backgroundImage;
    public string $primaryColor;
    public string $secondaryColor;
    public ?string $musicUrl;
    public ?string $videoUrl;

}