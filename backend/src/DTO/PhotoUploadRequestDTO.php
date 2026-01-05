<?php

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class PhotoUploadRequestDTO
{
    #[Assert\NotNull]
    #[Assert\File(
        maxSize: '5M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp']
    )]
    public ?UploadedFile $photo = null;

    #[Assert\Length(max: 255)]
    public ?string $caption = null;

    public function __construct(?UploadedFile $photo = null, ?string $caption = null)
    {
        $this->photo = $photo;
        $this->caption = $caption;
    }
}
