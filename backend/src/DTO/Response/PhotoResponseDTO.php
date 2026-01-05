<?php

namespace App\DTO;

class PhotoResponseDTO
{
    public int $id;
    public string $url;
    public ?string $caption;

    public function __construct(int $id, string $url, ?string $caption)
    {
        $this->id = $id;
        $this->url = $url;
        $this->caption = $caption;
    }
}
