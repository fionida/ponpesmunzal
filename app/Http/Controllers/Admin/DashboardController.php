<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Registration;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'postsCount' => Post::query()->count(),
            'publishedCount' => Post::query()->where('status', 'published')->count(),
            'galleriesCount' => Gallery::query()->count(),
            'registrationsNew' => Registration::query()->where('status', 'baru')->count(),
            'messagesUnread' => ContactMessage::query()->where('is_read', false)->count(),
            'latestPosts' => Post::query()->latest()->take(5)->get(),
            'latestRegistrations' => Registration::query()->latest()->take(5)->get(),
        ]);
    }
}
