<?php

namespace Database\Seeders;

use App\Models\DailySchedule;
use App\Models\Facility;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\PageContent;
use App\Models\Post;
use App\Models\Program;
use App\Models\SiteProfile;
use App\Models\TimelineEvent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@nurulhuda.ac.id'],
            ['name' => 'Administrator', 'password' => 'password']
        );

        SiteProfile::query()->updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Pondok Pesantren Nurul Huda',
                'tagline' => 'Ilmu • Adab • Manfaat',
                'motto' => 'Membangun Generasi Qur’ani, Berilmu dan Berakhlakul Karimah',
                'about' => 'Pondok Pesantren Nurul Huda berdiri sebagai lembaga pendidikan Islam yang memadukan pengajian kitab, tahfidz, dan pendidikan formal. Santri dibina secara utuh: ibadah, akhlak, dan kecakapan hidup.',
                'history' => 'Didirikan pada 2004 oleh KH. Ahmad Fauzi, Lc., pondok ini berawal dari pengajian kecil yang kemudian tumbuh menjadi lembaga pendidikan dengan asrama, madrasah, dan jenjang formal.',
                'vision' => 'Menjadi pesantren unggul yang mencetak generasi Qur’ani, berilmu, beradab, dan bermanfaat bagi umat serta bangsa.',
                'mission' => "Menyelenggarakan pendidikan tahfidz dan diniyah yang mutqin.\nMengintegrasikan kurikulum formal dengan nilai pesantren.\nMembina akhlak melalui keteladanan dan pembiasaan.\nMenumbuhkan jiwa pengabdian dan kemandirian santri.",
                'goals' => "Santri hafal dan memahami Al-Qur’an sesuai jenjang.\nSantri mampu membaca kitab dan berpikir jernih.\nSantri memiliki adab kepada guru, teman, dan masyarakat.\nAlumni siap berkhidmat di berbagai bidang.",
                'pengasuh_name' => 'KH. Ahmad Fauzi, Lc.',
                'pengasuh_title' => 'Pengasuh Pondok Pesantren Nurul Huda',
                'pengasuh_bio' => 'Beliau menempuh pendidikan di pesantren dan perguruan tinggi di Timur Tengah, lalu pulang mengabdikan ilmu untuk membangun generasi yang kokoh dalam iman dan luas dalam wawasan.',
                'features' => "Asrama Nyaman\nPembinaan 24 Jam\nLingkungan Islami\nFasilitas Lengkap",
                'registration_docs' => "Fotokopi KK dan akta kelahiran\nPas foto 3x4\nRapor terakhir\nSurat keterangan sehat",
                'registration_programs' => "Tahfidz Al-Qur’an\nMadrasah Diniyah\nPendidikan Formal\nKombinasi (Tahfidz + Formal)",
                'address' => 'Jl. Pesantren No. 12, Lowokwaru, Malang, Jawa Timur',
                'phone' => '(0341) 555-0123',
                'whatsapp' => '0812-3456-7890',
                'email' => 'info@nurulhuda.ac.id',
                'hours' => 'Senin–Sabtu, 07.00–16.00',
                'stat_years' => '20+',
                'stat_students' => '1.500+',
                'stat_teachers' => '100+',
                'stat_alumni' => '10.000+',
                'youtube' => '#',
                'facebook' => '#',
                'instagram' => '#',
                'tiktok' => '#',
                'map_embed' => 'https://maps.google.com/maps?q=Malang%20Jawa%20Timur&t=&z=13&ie=UTF8&iwloc=&output=embed',
            ]
        );

        foreach ([
            ['Pembukaan Tahun Ajaran Baru 2024/2025', 'Kegiatan', 'Rangkaian pengajian, doa bersama, dan orientasi santri menandai dimulainya tahun ajaran.'],
            ['Haflah Imtihan dan Pengumuman Prestasi', 'Akademik', 'Santri menunjukkan hasil belajar melalui ujian dan apresiasi prestasi.'],
            ['Pengabdian Santri di Masyarakat Sekitar', 'Sosial', 'Kegiatan bakti sosial sebagai wujud manfaat ilmu bagi lingkungan.'],
            ['Peringatan Isra Mi’raj di Masjid Pondok', 'Keagamaan', 'Pengajian dan doa bersama memperingati perjalanan Rasulullah SAW.'],
            ['Jadwal Pendaftaran Santri Baru Gelombang II', 'Pengumuman', 'Informasi syarat dan jadwal pendaftaran untuk wali santri.'],
            ['Adab Menuntut Ilmu di Era Digital', 'Artikel', 'Refleksi tentang menjaga adab saat belajar dengan teknologi.'],
        ] as $i => [$title, $category, $excerpt]) {
            Post::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'category' => $category,
                    'excerpt' => $excerpt,
                    'body' => $excerpt."\n\nKonten lengkap dapat diperbarui melalui panel admin CMS.",
                    'status' => 'published',
                    'published_at' => now()->subDays($i * 7),
                ]
            );
        }

        foreach ([
            ['Kegiatan Rutin Khataman Al-Qur’an', 'Kegiatan Keagamaan', 'foto'],
            ['Pembukaan Tahun Ajaran Baru', 'Kegiatan Harian', 'foto'],
            ['Kajian Kitab Kuning', 'Kegiatan Akademik', 'foto'],
            ['Olahraga Pagi Santri', 'Ekstrakurikuler', 'foto'],
            ['Profil Pondok Pesantren Nurul Huda', 'Kegiatan Harian', 'video'],
            ['Khataman Al-Qur’an 2024', 'Kegiatan Keagamaan', 'video'],
        ] as $i => [$title, $category, $type]) {
            Gallery::query()->updateOrCreate(
                ['title' => $title],
                [
                    'category' => $category,
                    'type' => $type,
                    'duration' => $type === 'video' ? '0'.($i + 3).':30' : null,
                    'taken_at' => now()->subDays($i * 3)->toDateString(),
                    'is_featured' => $i < 4,
                ]
            );
        }

        foreach ([
            ['Tahfidz Al-Qur’an', 'Hafalan bertahap dengan bimbingan murajaah harian.'],
            ['Madrasah Diniyah', 'Kajian kitab dan ilmu alat untuk fondasi keilmuan.'],
            ['Pendidikan Formal', 'Jenjang formal yang terintegrasi dengan nilai pesantren.'],
            ['Bahasa Arab & Inggris', 'Pembiasaan bilingual untuk wawasan dan komunikasi.'],
            ['Ekstrakurikuler', 'Bakat, olahraga, dan kepemimpinan santri.'],
        ] as $i => [$title, $desc]) {
            Program::query()->updateOrCreate(['title' => $title], [
                'description' => $desc,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        foreach ([
            ['Ruang Kelas Modern', 'pendidikan'],
            ['Perpustakaan Lengkap', 'pendidikan'],
            ['Laboratorium Komputer', 'pendidikan'],
            ['Masjid', 'pendidikan'],
            ['Asrama Santri', 'pendidikan'],
            ['Area Olahraga', 'pendidikan'],
            ['Ruang Kelas Modern', 'umum'],
            ['Asrama Nyaman', 'umum'],
            ['Masjid Representatif', 'umum'],
            ['Perpustakaan Lengkap', 'umum'],
            ['Area Olahraga Terpadu', 'umum'],
            ['Lingkungan Asri dan Aman', 'umum'],
        ] as $i => [$title, $group]) {
            Facility::query()->updateOrCreate(
                ['title' => $title, 'group' => $group],
                ['sort_order' => $i + 1, 'is_active' => true]
            );
        }

        foreach ([
            ['Kapan pendaftaran dibuka?', 'Pendaftaran dibuka setiap semester. Informasi gelombang diumumkan di halaman berita.'],
            ['Apa saja syarat masuk?', 'Fotokopi KK, akta, rapor, dan surat sehat. Detail dikirim setelah formulir awal masuk.'],
            ['Apakah ada program tahfidz?', 'Ya, tahfidz menjadi program unggulan yang berjalan paralel dengan diniyah dan formal.'],
            ['Bolehkah wali berkunjung?', 'Kunjungan mengikuti jadwal yang diumumkan pengurus asrama.'],
            ['Bagaimana biaya pendidikan?', 'Rincian biaya disampaikan panitia saat konsultasi pendaftaran.'],
        ] as $i => [$q, $a]) {
            Faq::query()->updateOrCreate(['question' => $q], [
                'answer' => $a,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        foreach ([
            ['2004', 'Pendirian pondok dan pengajian perdana.'],
            ['2008', 'Pembangunan asrama dan masjid utama.'],
            ['2012', 'Pembukaan program tahfidz terstruktur.'],
            ['2018', 'Integrasi pendidikan formal.'],
            ['2024', 'Penguatan kurikulum dan jaringan alumni.'],
        ] as $i => [$year, $title]) {
            TimelineEvent::query()->updateOrCreate(['year' => $year], [
                'title' => $title,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        foreach ([
            ['03.30', 'Shalat Tahajud & Witir'],
            ['04.30', 'Shalat Subuh & Al-Ma’tsurat'],
            ['05.30', 'Setoran Tahfidz'],
            ['07.00', 'Pendidikan Formal'],
            ['12.30', 'Dzuhur & Istirahat'],
            ['14.00', 'Madrasah Diniyah'],
            ['16.00', 'Ekstrakurikuler'],
            ['18.00', 'Maghrib & Mengaji'],
            ['20.00', 'Belajar Malam'],
            ['22.00', 'Istirahat'],
        ] as $i => [$time, $activity]) {
            DailySchedule::query()->updateOrCreate(['time' => $time], [
                'activity' => $activity,
                'sort_order' => $i + 1,
                'is_active' => true,
            ]);
        }

        $pageContents = [
            ['beranda', 'beranda.hero_eyebrow', 'Hero eyebrow', 'text', 'PONDOK PESANTREN NURUL HUDA'],
            ['beranda', 'beranda.hero_title', 'Hero judul', 'textarea', 'Membangun Generasi Qur’ani, Berilmu dan Berakhlakul Karimah'],
            ['beranda', 'beranda.hero_text', 'Hero teks', 'textarea', 'Lingkungan pendidikan yang memadukan ilmu agama dan pengetahuan umum, menumbuhkan adab, serta menyiapkan santri bermanfaat bagi umat.'],
            ['beranda', 'beranda.hero_quote', 'Hero kutipan', 'textarea', 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia.'],
            ['beranda', 'beranda.hero_quote_by', 'Hero sumber kutipan', 'text', 'HR. Ahmad'],
            ['beranda', 'beranda.stats_arabic', 'Statistik Arab', 'text', 'اطلبوا العلم'],
            ['beranda', 'beranda.stats_quote', 'Statistik kutipan', 'textarea', 'Tuntutlah ilmu dari buaian hingga liang lahat.'],
            ['beranda', 'beranda.sambutan_title', 'Judul sambutan', 'text', 'Merawat Tradisi, Menyongsong Masa Depan'],
            ['beranda', 'beranda.feature_title', 'Judul kotak fitur', 'text', 'Lingkungan yang Mendidik dan Membentuk'],
            ['beranda', 'beranda.feature_text', 'Teks kotak fitur', 'textarea', 'Pembinaan berlangsung di asrama, kelas, dan masjid — bukan hanya di ruang belajar.'],
            ['beranda', 'beranda.cta_title', 'CTA judul', 'text', 'Bergabunglah Bersama Kami'],
            ['beranda', 'beranda.cta_text', 'CTA teks', 'textarea', 'Buka kesempatan bagi putra-putri untuk tumbuh dalam lingkungan yang merawat ilmu, adab, dan manfaat.'],
            ['beranda', 'beranda.cta_quote', 'CTA kutipan', 'textarea', 'Belajar adalah perjalanan panjang. Setiap langkah kecil hari ini adalah bekal untuk bermanfaat esok hari.'],
            ['profil', 'profil.hero_title', 'Hero judul', 'text', 'Profil Pondok Pesantren Nurul Huda'],
            ['profil', 'profil.hero_text', 'Hero teks', 'textarea', 'Mengenal sejarah, visi, pengasuh, dan arah pendidikan yang merawat tradisi sekaligus menyongsong masa depan.'],
            ['profil', 'profil.blockquote', 'Kutipan sekilas', 'textarea', 'Ilmu yang bermanfaat adalah ilmu yang menuntun adab, dan adab yang baik menuntun manfaat bagi sesama.'],
            ['profil', 'profil.pengasuh_quote_ar', 'Kutipan pengasuh Arab', 'text', 'وَقُل رَّبِّ زِدْنِي عِلْمًا'],
            ['profil', 'profil.pengasuh_quote', 'Kutipan pengasuh', 'textarea', 'Ya Tuhanku, tambahkanlah ilmu kepadaku.'],
            ['profil', 'profil.pengasuh_quote_by', 'Sumber kutipan pengasuh', 'text', 'QS. Thaha: 114'],
            ['profil', 'profil.cta_title', 'CTA judul', 'text', 'Mari menjadi bagian dari keluarga besar Nurul Huda'],
            ['pendidikan', 'pendidikan.hero_title', 'Hero judul', 'textarea', 'Pendidikan Menyeluruh untuk Membentuk Generasi Unggul'],
            ['pendidikan', 'pendidikan.hero_text', 'Hero teks', 'textarea', 'Kurikulum terpadu yang memadukan tahfidz, diniyah, pendidikan formal, dan pembiasaan bahasa.'],
            ['pendidikan', 'pendidikan.quote', 'Kutipan', 'textarea', 'Menuntut ilmu adalah kewajiban bagi setiap muslim.'],
            ['pendidikan', 'pendidikan.quote_ar', 'Kutipan Arab', 'text', 'طَلَبُ الْعِلْمِ فَرِيضَةٌ'],
            ['pendidikan', 'pendidikan.quote_by', 'Sumber kutipan', 'text', 'HR. Ibnu Majah'],
            ['pendidikan', 'pendidikan.kurikulum_title', 'Judul kurikulum', 'text', 'Kurikulum Terintegrasi'],
            ['pendidikan', 'pendidikan.kurikulum_text', 'Teks kurikulum', 'textarea', 'Setiap hari santri menjalani siklus ibadah, mengaji, kelas formal, dan pembiasaan adab yang saling menopang.'],
            ['pendidikan', 'pendidikan.metode', 'Metode (judul|deskripsi per baris)', 'textarea', "Sorogan & Bandongan|Bimbingan kitab secara personal dan klasikal.\nHalaqah & Diskusi|Melatih pemahaman dan adab berbicara.\nPraktik & Pembiasaan|Ilmu diamalkan dalam kehidupan asrama.\nEvaluasi Berkala|Setoran, ujian, dan rapor perkembangan."],
            ['pendidikan', 'pendidikan.cta_title', 'CTA judul', 'text', 'Bersama Kami, Wujudkan Masa Depan yang Lebih Baik.'],
            ['kegiatan', 'kegiatan.hero_title', 'Hero judul', 'text', 'Kegiatan Pesantren'],
            ['kegiatan', 'kegiatan.hero_text', 'Hero teks', 'textarea', 'Rangkaian kegiatan yang menumbuhkan ilmu, adab, kepemimpinan, dan kepedulian sosial santri.'],
            ['kegiatan', 'kegiatan.quote', 'Kutipan', 'textarea', 'Kegiatan pondok bukan pengisi waktu, melainkan ruang membentuk karakter.'],
            ['kegiatan', 'kegiatan.unggulan_title', 'Judul unggulan', 'text', 'Rutinan Ngaji Kitab Kuning'],
            ['kegiatan', 'kegiatan.unggulan_text', 'Teks unggulan', 'textarea', 'Kajian bandongan dan sorogan yang merawat sanad keilmuan, membentuk adab kepada guru, dan menajamkan pemahaman fikih, akhlak, serta tafsir.'],
            ['kegiatan', 'kegiatan.manfaat', 'Manfaat (satu baris per item)', 'textarea', "Memperdalam ilmu agama\nMelatih adab kepada guru\nMenjaga kesinambungan tradisi\nMembuka ruang diskusi ilmiah\nMembentuk karakter istiqamah"],
            ['berita', 'berita.hero_title', 'Hero judul', 'text', 'Berita & Informasi'],
            ['berita', 'berita.hero_text', 'Hero teks', 'textarea', 'Kabar kegiatan, prestasi, pengumuman, dan liputan kehidupan pondok.'],
            ['berita', 'berita.quote', 'Kutipan', 'textarea', 'Sampaikanlah dariku walau hanya satu ayat.'],
            ['berita', 'berita.quote_by', 'Sumber kutipan', 'text', 'HR. Bukhari'],
            ['galeri', 'galeri.hero_title', 'Hero judul', 'text', 'Galeri Kegiatan'],
            ['galeri', 'galeri.hero_text', 'Hero teks', 'textarea', 'Dokumentasi perjalanan, ibadah, belajar, dan kehidupan sehari-hari santri.'],
            ['galeri', 'galeri.quote', 'Kutipan', 'textarea', 'Setiap momen adalah bagian dari proses mendidik generasi.'],
            ['kontak', 'kontak.hero_title', 'Hero judul', 'text', 'Hubungi Kami'],
            ['kontak', 'kontak.hero_text', 'Hero teks', 'textarea', 'Silaturahmi, pertanyaan pendaftaran, kerja sama, dan saran sangat kami buka.'],
            ['kontak', 'kontak.quote', 'Kutipan', 'textarea', 'Tolong-menolonglah kamu dalam (mengerjakan) kebajikan dan takwa.'],
            ['kontak', 'kontak.quote_ar', 'Kutipan Arab', 'text', 'وَتَعَاوَنُوا عَلَى الْبِرِّ وَالتَّقْوَىٰ'],
            ['kontak', 'kontak.quote_by', 'Sumber kutipan', 'text', 'QS. Al-Ma’idah: 2'],
            ['kontak', 'kontak.transport', 'Akses transportasi (judul|teks per baris)', 'textarea', "Kendaraan Pribadi|Dari pusat kota Malang sekitar 20–30 menit.\nAngkutan Umum|Naik angkot atau bus kota menuju Lowokwaru.\nBandara|Dari Bandara Abd. Saleh sekitar 25 menit.\nStasiun|Dari Stasiun Malang Kota sekitar 20 menit."],
            ['pendaftaran', 'pendaftaran.hero_title', 'Hero judul', 'text', 'Pendaftaran Santri Baru'],
            ['pendaftaran', 'pendaftaran.hero_text', 'Hero teks', 'textarea', 'Isi formulir awal. Panitia akan menghubungi wali untuk langkah berikutnya.'],
        ];

        foreach ($pageContents as [$group, $key, $label, $type, $value]) {
            PageContent::query()->updateOrCreate(
                ['key' => $key],
                compact('group', 'label', 'type', 'value')
            );
        }
    }
}
