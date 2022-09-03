<?php

declare(strict_types=1);

namespace App\Repository;

use App\Models\Profile;

class ProfileRepository
{
    public const STORAGE_PATH = __DIR__ . '/../../storage/app/public/';

    /**
     * Removes old profile's image
     * @throws \Exception
     */
    public function removeImageById(int $id): void
    {
        $profile = Profile::findOrFail($id);

        if (isset($profile->image)) {
            $path = self::STORAGE_PATH . $profile->image;
            if (!file_exists($path)) {
                throw new \Exception("no such file or directory:" . $path);
            }
            unlink($path);
        }
    }
}