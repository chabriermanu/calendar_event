<?php

namespace App\DTO\Response;

class FamilleProfileResponse
{
    public int $id;
    public string $avatar;
    public string $familyRole;
    public bool $hasCalendarAccess;
    public ?ThemeResponse $theme = null;
}
