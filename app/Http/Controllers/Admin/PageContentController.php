<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class PageContentController extends Controller
{
    private const SECTION_LABELS = [
        'hero' => 'Hero',
        'stats' => 'Statistik',
        'stat' => 'Label Statistik',
        'programs' => 'Program',
        'sambutan' => 'Sambutan',
        'feature' => 'Kotak Fitur',
        'gallery' => 'Galeri',
        'news' => 'Berita',
        'cta' => 'CTA / Ajakan',
        'sekilas' => 'Sekilas',
        'blockquote' => 'Kutipan',
        'visi' => 'Visi & Misi',
        'sejarah' => 'Sejarah',
        'pengasuh' => 'Pengasuh',
        'fasilitas' => 'Fasilitas',
        'prestasi' => 'Prestasi',
        'quote' => 'Kutipan',
        'highlights' => 'Highlight',
        'kurikulum' => 'Kurikulum',
        'metode' => 'Metode',
        'jadwal' => 'Jadwal',
        'aside' => 'Samping / Aside',
        'list' => 'Daftar',
        'unggulan' => 'Unggulan',
        'manfaat' => 'Manfaat',
        'galeri' => 'Galeri',
        'foto' => 'Foto',
        'video' => 'Video',
        'form' => 'Formulir',
        'subjects' => 'Opsi Subjek',
        'aside_quote' => 'Kutipan Samping',
        'help' => 'Bantuan',
        'transport' => 'Transportasi',
        'docs' => 'Dokumen',
    ];

    private const PAGE_LABELS = [
        'beranda' => 'Beranda',
        'profil' => 'Profil',
        'pendidikan' => 'Pendidikan',
        'kegiatan' => 'Kegiatan',
        'berita' => 'Berita',
        'galeri' => 'Galeri',
        'kontak' => 'Kontak',
        'pendaftaran' => 'Pendaftaran',
    ];

    public function edit(Request $request): View
    {
        $allGroups = PageContent::query()
            ->orderBy('group')
            ->orderBy('id')
            ->get()
            ->groupBy('group');

        $pages = $allGroups->keys()->mapWithKeys(fn ($key) => [
            $key => self::PAGE_LABELS[$key] ?? ucfirst($key),
        ]);

        $active = $request->string('halaman')->toString();
        if ($active === '' || ! $allGroups->has($active)) {
            $active = $allGroups->keys()->first() ?? 'beranda';
        }

        $items = $allGroups->get($active, collect());
        $sections = $this->groupIntoSections($items);

        return view('admin.page-contents.edit', [
            'pages' => $pages,
            'active' => $active,
            'sections' => $sections,
            'pageLabel' => self::PAGE_LABELS[$active] ?? ucfirst($active),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $values = $request->input('values', []);
        $halaman = $request->input('halaman');

        foreach ($values as $key => $value) {
            PageContent::query()->where('key', $key)->update(['value' => $value]);
        }

        return redirect()
            ->route('admin.konten.edit', array_filter(['halaman' => $halaman]))
            ->with('success', 'Konten halaman berhasil disimpan.');
    }

    private function groupIntoSections(Collection $items): Collection
    {
        return $items
            ->groupBy(function (PageContent $item) {
                $parts = explode('.', $item->key, 2);
                $rest = $parts[1] ?? $item->key;
                $segment = explode('_', $rest)[0] ?? 'umum';

                return $segment;
            })
            ->map(function (Collection $sectionItems, string $section) {
                return [
                    'key' => $section,
                    'label' => self::SECTION_LABELS[$section] ?? ucfirst($section),
                    'items' => $sectionItems,
                ];
            })
            ->values();
    }
}
