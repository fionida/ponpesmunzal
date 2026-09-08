<?php

namespace App\Http\Controllers;

use App\Models\DailySchedule;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\SiteProfile;
use App\Models\TimelineEvent;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function beranda(): View
    {
        return view('pages.beranda', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'programs' => Program::query()->where('is_active', true)->orderBy('sort_order')->take(4)->get(),
            'posts' => Post::query()->published()->latest('published_at')->take(3)->get(),
            'galleries' => Gallery::query()->where('type', 'foto')->latest()->take(5)->get(),
        ]);
    }

    public function profil(): View
    {
        return view('pages.profil', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'timelines' => TimelineEvent::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'facilities' => Facility::query()->where('is_active', true)->where('group', 'umum')->orderBy('sort_order')->get(),
        ]);
    }

    public function pendidikan(): View
    {
        return view('pages.pendidikan', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'programs' => Program::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'facilities' => Facility::query()->where('is_active', true)->where('group', 'pendidikan')->orderBy('sort_order')->get(),
            'schedules' => DailySchedule::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function kegiatan(): View
    {
        return view('pages.kegiatan', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'posts' => Post::query()->published()->latest('published_at')->take(5)->get(),
            'galleries' => Gallery::query()->latest()->take(6)->get(),
        ]);
    }

    public function berita(Request $request): View
    {
        $posts = Post::query()
            ->published()
            ->when($request->q, fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($request->kategori, fn ($q, $cat) => $q->where('category', $cat))
            ->latest('published_at')
            ->paginate(7)
            ->withQueryString();

        return view('pages.berita', [
            'contents' => PageContent::allMapped(),
            'posts' => $posts,
            'popular' => Post::query()->published()->latest('published_at')->take(5)->get(),
            'featured' => $posts->first(),
        ]);
    }

    public function beritaShow(Post $post): View
    {
        abort_unless($post->status === 'published', 404);

        return view('pages.berita-show', compact('post'));
    }

    public function galeri(Request $request): View
    {
        return view('pages.galeri', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'fotos' => Gallery::query()
                ->where('type', 'foto')
                ->when($request->kategori, fn ($q, $cat) => $q->where('category', $cat))
                ->latest()
                ->take(16)
                ->get(),
            'videos' => Gallery::query()->where('type', 'video')->latest()->take(4)->get(),
        ]);
    }

    public function kontak(): View
    {
        return view('pages.kontak', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
            'faqs' => Faq::query()->where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }

    public function pendaftaran(): View
    {
        return view('pages.pendaftaran', [
            'profile' => SiteProfile::current(),
            'contents' => PageContent::allMapped(),
        ]);
    }
}
