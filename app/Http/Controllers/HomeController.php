<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\LinkedInQueryService;
use App\Services\ImageUploadService;
use App\Services\UserProfileService;
use App\Models\Occupation;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use App\Mail\ContactMail;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Services\SeoGeneratorService;


class HomeController extends Controller
{

    public function index()
    {
        $categories = JobCategory::where('status', true)
            ->withCount('occupations')
            ->orderByDesc('occupations_count')
            ->orderBy('title')
            ->get();

        $featuredJobs = Occupation::orderByDesc('posted_at')
            ->take(6)
            ->get();

        return view('frontend.index',[
            'categories' => $categories,
            'featuredJobs' => $featuredJobs
        ]);
    }

    public function alljobView(Request $request, LinkedInQueryService $queryService)
    {
        // Handle category slug from route parameter
        if ($request->has('category') && !is_numeric($request->input('category'))) {
            $category = JobCategory::where('slug', $request->input('category'))->first();
            if ($category) {
                $request->merge(['category' => $category->id]);
            }
        }


        $occupations = $queryService->getLinkedInJobs($request);
        $totalCount = $occupations->total();
        $perPage = $occupations->perPage();

        // Get categories for filter dropdown
        $categories = JobCategory::where('status', true)
            ->orderBy('title')
            ->get();

        $jobTypes = JobType::where('status', true)
            ->orderBy('title')
            ->get();


        return view('frontend.job', [
            'occupations' => $occupations,
            'totalCount' => $totalCount,
            'perPage' => $perPage,
            'categories' => $categories,
            'request' => $request,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function jobDetail($slug, $job_id)
    {
        $job = Occupation::where('slug', $slug)->where('job_id', $job_id)->first();

        if (!$job) {
            abort(404, 'Job not found');
        }

        $relatedJobs = Occupation::where('id', '!=', $job->id)
            ->where('category_id', $job->category_id)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('frontend.detail', [
            'job' => $job,
            'relatedJobs' => $relatedJobs,
        ]);
    }

    public function contactUs()
    {
        return view('frontend.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        try {
            // Get admin email from config or use a default
            $adminEmail = config('mail.from.address');

            // Send email to admin
            Mail::to($adminEmail)->send(new ContactMail(
                $validated['name'],
                $validated['email'],
                $validated['subject'],
                $validated['message']
            ));

            return redirect()->route('contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
        } catch (\Exception $e) {
            return redirect()->route('contact')
                ->withInput()
                ->with('error', 'Sorry, there was an error sending your message. Please try again later.');
        }
    }

    public function myProfile()
    {
        $user = Auth::user();

        if($user->role == '1')
        {
            return redirect()->route('dashboard');
        } else {
            return view('frontend.profile', [
                'user' => $user
            ]);
        }
    }

    public function updateProfile(ProfileUpdateRequest $request, ImageUploadService $imageUploadService, UserProfileService $userProfileService)
    {
        $validated = $request->validated();

        $userProfileService->updateOrCreateUser($validated, $request, $imageUploadService);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check if current password matches
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->route('profile.show')
                ->with('error', 'Current password is incorrect.')
                ->withInput();
        }

        // Update password
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }

    public function submitJobApplication(ProfileUpdateRequest $request, ImageUploadService $imageUploadService, UserProfileService $userProfileService)
    {
        $validated = $request->validated();

        $request->validate([
            'job_id' => 'required|exists:occupations,id',
        ]);

        $job = Occupation::findOrFail($request->job_id);

        // Create or Update User
        $user = $userProfileService->updateOrCreateUser($validated, $request, $imageUploadService);

        // Redirect to third-party job apply link
        return redirect($job->link)->with('success', 'Your application has been submitted successfully!');
    }


    public function test()
    {
        return view('frontend.test');
    }

    public function seoGeneratorAPI(Request $request, SeoGeneratorService $seoGeneratorService)
    {
        $query = $request->input('query');

        $seoData = $seoGeneratorService->generateSeoContent($query);

        return response()->json($seoData);
    }
}
