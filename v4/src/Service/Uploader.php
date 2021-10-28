<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Uploader
{
    private $targetDirectory;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $fichierForm, $prefix, $categorie)
    {
        $nouveau_nomFichier = $prefix . '-' . uniqid() . '.' . $fichierForm->guessExtension();

        try
        {
            $fichierForm->move($this->getTargetDirectory($categorie), $nouveau_nomFichier);
        }
        catch (FileException $e)
        {
            // ... handle exception if something happens during file upload
        }

        return $nouveau_nomFichier;
    }

    public function getTargetDirectory($categorie)
    {
        return $this->targetDirectory . '/' . $categorie;
    }
}