<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ImageUploadService
{
    /**
     * Upload an image and optionally delete the old image.
     *
     * @return string The new image path
     */
    public function uploadImage(UploadedFile $image, string $directory, ?string $oldImagePath = null, ?string $prefix = null): string
    {
        // Delete old image if exists
        if ($oldImagePath && File::exists(public_path($oldImagePath))) {
            File::delete(public_path($oldImagePath));
        }

        // Generate unique filename
        $filename = ($prefix ?? '').time().'.'.$image->getClientOriginalExtension();

        // Ensure directory exists
        $destinationPath = public_path($directory);
        if (! File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        // Move the file
        $image->move($destinationPath, $filename);

        // Return the relative path to the image
        return $directory.'/'.$filename;
    }
}
