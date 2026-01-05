<?php

namespace App\Mapper;

use App\DTO\Response\FamilleProfileResponse;
use App\DTO\Response\ThemeResponse;
use App\DTO\Response\UserMeResponse;
use App\Entity\Famille;
use App\Entity\Theme;
use App\Entity\User;

class UserMapper
{
    public function toUserMeResponse(User $user): UserMeResponse
    {
        $dto = new UserMeResponse();
        $dto->id = $user->getId();
        $dto->pseudo = $user->getPseudo();
        $dto->age = $user->getAge();
        $dto->avatar = $user->getAvatar();
        $dto->roles = $user->getRoles();

        return $dto;
    }

    public function toFamilleProfileResponse(Famille $famille): FamilleProfileResponse
    {
        $dto = new FamilleProfileResponse();
        $dto->id = $famille->getId();
        $dto->avatar = $famille->getAvatar();
        $dto->familyRole = $famille->getFamilyRole();
        $dto->hasCalendarAccess = $famille->hasCalendarAccess();
        
        if ($famille->getTheme() !== null) {
            $dto->theme = $this->toThemeResponse($famille->getTheme());
        }

        return $dto;
    }

    private function toThemeResponse(Theme $theme): ThemeResponse
    {
        $dto = new ThemeResponse();
        $dto->id = $theme->getId();
        $dto->name = $theme->getName();
        $dto->backgroundImage = $theme->getBackgroundImage();
        $dto->primaryColor = $theme->getPrimaryColor();
        $dto->secondaryColor = $theme->getSecondaryColor();
        $dto->musicUrl = $theme->getMusicUrl();
        $dto->videoUrl = $theme->getVideoUrl();

        return $dto;
    }
}