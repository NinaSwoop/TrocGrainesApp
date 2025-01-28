<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class UploadFileController
{
    #[Route('/upload_file', name: 'upload_file', methods: ['POST'])]
    public function uploadFile(Request $request,
    SluggerInterface $slugger,
    #[Autowire('%kernel.project_dir%/public/uploads')] string $filesDirectory): JsonResponse
    {
        $file = $request->files->get('file');

        if ($file) {
            $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $filename = $safeFilename.'-'.uniqid() . '.' . $file->guessExtension();
        }

        try {
            $file->move($filesDirectory, $filename);
        } catch (FileException $e) {
            return new JsonResponse('File upload failed: ' . $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return new JsonResponse($filename, Response::HTTP_CREATED);
    }
}