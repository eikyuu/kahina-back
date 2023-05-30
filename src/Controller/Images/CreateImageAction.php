<?php

namespace App\Controller\Images;

use App\Entity\Anime;
use App\Entity\Episode;
use App\Entity\Images\Thumbnail;
use App\Entity\Images\CoverImage;
use App\Entity\Images\StaffImage;
use App\Entity\Images\FigureImage;
use App\Entity\Images\PosterImage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
final class CreateImageAction extends AbstractController
{
    public function __invoke(Request $request, DenormalizerInterface $denormalizer) : FigureImage | CoverImage | StaffImage | PosterImage | Thumbnail
    {
        $cibleClass = Anime::class;
        $baseUrl = "/api/animes/";

        $uploadedFile = $request->files->get('image');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('image is missing');
        }

        switch ($request->attributes->get('_api_operation')->getShortName()) {
            case 'create-figure-image-item':
                $mediaObject = new FigureImage();
                $baseUrl = "/api/figures/";
                $mediaObject->setFigure($denormalizer->denormalize($baseUrl.$request->request->get('slug'), $cibleClass));
                break;
            case 'create-cover-image-item':
                $mediaObject = new CoverImage();
                $mediaObject->setAnime($denormalizer->denormalize($baseUrl.$request->request->get('slug'), $cibleClass));
                break;
            case 'create-staff-image-item':
                $mediaObject = new StaffImage();
                $baseUrl = "/api/staff/";
                $mediaObject->setStaff($denormalizer->denormalize($baseUrl.$request->request->get('slug'), $cibleClass));
                break;
            case 'create-poster-image-item':
                $mediaObject = new PosterImage();
                $mediaObject->setAnime($denormalizer->denormalize($baseUrl.$request->request->get('slug'), $cibleClass));
                break;
            case 'create-thumbnail-image-item':
                $mediaObject = new Thumbnail();
                $baseUrl = "/api/episodes/";
                $cibleClass = Episode::class;
                $mediaObject->setEpisode($denormalizer->denormalize($baseUrl.$request->request->get('slug'), $cibleClass));
                break;
        }
        
        if ($uploadedFile instanceof UploadedFile) {
            $mediaObject->setImageFile($uploadedFile);
        }

        return $mediaObject;
    }
}