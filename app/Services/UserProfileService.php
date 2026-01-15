<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserProfileService
{
    public function updateOrCreateUser(array $validated, $request, ImageUploadService $imageUploadService)
    {
        // Find user by email
        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            $user = new User();
            $user->email = $validated['email'];
            $user->password = Hash::make(Str::random(16));
            $user->role = 2;
            $user->status = 'active';
        }

        // Name
        $firstName = $validated['first_name'] ?? $user->first_name ?? '';
        $lastName  = $validated['last_name'] ?? $user->last_name ?? '';
        $user->name = trim($firstName . ' ' . $lastName);

        // Basic Fields
        $user->first_name = $validated['first_name'] ?? $user->first_name;
        $user->last_name = $validated['last_name'] ?? $user->last_name;
        $user->phone = $validated['phone'] ?? $user->phone;
        $user->date_of_birth = $validated['date_of_birth'] ?? $user->date_of_birth;
        $user->location = $validated['location'] ?? $user->location;
        $user->professional_title = $validated['professional_title'] ?? $user->professional_title;
        $user->cover_letter = $validated['cover_letter'] ?? $user->cover_letter;

        /* =============================
           Avatar Upload
        ==============================*/
        if ($request->hasFile('avatar')) {
            $avatarPath = $imageUploadService->uploadImage(
                $request->file('avatar'),
                'uploads/avatars',
                $user->avatar,
                'avatar_'
            );
            $user->avatar = $avatarPath;
        }

        /* =============================
           Resume Upload
        ==============================*/
        if ($request->hasFile('resume')) {
            $resumeFile = $request->file('resume');
            $resumeFilename = 'resume_' . time() . '.' . $resumeFile->getClientOriginalExtension();
            $resumeDirectory = public_path('uploads/resumes');

            if (!File::exists($resumeDirectory)) {
                File::makeDirectory($resumeDirectory, 0755, true);
            }

            if ($user->resume && File::exists(public_path($user->resume))) {
                File::delete(public_path($user->resume));
            }

            $resumeFile->move($resumeDirectory, $resumeFilename);
            $user->resume = 'uploads/resumes/' . $resumeFilename;
        }

        $user->save();

        return $user;
    }
}
