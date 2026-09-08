@extends('layouts.app', ['title' => 'Detail Berita'])

@section('content')
@include('partials.page-hero', [
    'image' => $post->coverUrl(),
    'crumb' => 'Berita',
    'heading' => $post->title,
    'text' => $post->category.' · '.optional($post->published_at)->format('d M Y'),
])

<section class="py-16">
    <div class="container-site mx-auto max-w-3xl">
        <img src="{{ $post->coverUrl() }}" alt="{{ $post->title }}" class="mb-8 h-80 w-full rounded-3xl object-cover">
        @if ($post->excerpt)
            <p class="mb-6 text-lg text-muted">{{ $post->excerpt }}</p>
        @endif
        <div class="prose max-w-none whitespace-pre-line text-ink">{{ $post->body }}</div>
        <a href="{{ route('berita') }}" class="btn-forest mt-10">← Kembali ke Berita</a>
    </div>
</section>
@endsection
