<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureService
{
    public function __construct(
        private ParameterBagInterface $params,
        private SluggerInterface $slugger
    ){}

    public function addFeaturedImage(UploadedFile $featuredImage, ?string $folder = '')
    {
        $originalFileName = pathinfo($featuredImage->getClientOriginalName(),PATHINFO_FILENAME);
        $safeFileName = $this->slugger->slug($originalFileName);
        $newFileName = $safeFileName.'-'.uniqid().'.'.$featuredImage->guessExtension();
        $path = $this->params->get('images_directory') . $folder;
        $featuredImage->move(
            $path, $newFileName
        );
        return $newFileName;
    }
    public function deleteFeaturedImages(?string $featuredImage, ?string $folder = '')
    {
        if ($featuredImage) {
            $nomImage = $this->params->get('images_directory') . $folder;
            $min = $nomImage .'/'. $featuredImage;
            if (file_exists($min)) {
                unlink($min);
            }
        }
    }
}