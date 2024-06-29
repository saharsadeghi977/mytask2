<?php

namespace App\Http\Repositories;

use App\Http\Services\AttachmentService;
use App\Models\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileRepository
{
    public function upload(string $field, array $storages): array
    {
        $files = request()->files->get($field);
        if ($files instanceof UploadedFile) {
            $files = [$files];
        }

        $uploadedFiles = AttachmentService::instance()
            ->setStorages($storages)
            ->uploadFiles($files);
        $created = [];

        foreach ($uploadedFiles as $file) {
            $existingFile = File::query()->where('hash', $file['hash'])->first();
            if ($existingFile) {
                $created[] = $existingFile;
            } else {
                $createdFile = File::create([
                    'path' => $file['path'],
                    'storages' => $storages,
                    'type' => $file['mime'],
                    'hash' => $file['hash'],
                    'entry' => $file
                ]);
                $created[] = $createdFile;
            }
        }


        return $created;
    }
}
