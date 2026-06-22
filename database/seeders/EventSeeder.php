<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        $events = [
            [
                'title' => 'Java Jazz Festival 2026',
                'description' => 'Festival musik jazz terbesar di Asia Tenggara. Menampilkan musisi jazz internasional dan lokal terbaik. Nikmati 3 hari penuh dengan musik jazz, fusion, dan blues di venue indoor yang nyaman.',
                'location' => 'JIExpo Kemayoran, Jakarta',
                'event_date' => '2026-07-15 18:00:00',
                'price' => 750000,
                'quota' => 5000,
            ],
            [
                'title' => 'Coldplay Live in Jakarta',
                'description' => 'Konser spektakuler Coldplay dalam Music of the Spheres World Tour. Jangan lewatkan hits seperti Yellow, The Scientist, Fix You, dan lagu-lagu terbaru mereka dengan visual memukau.',
                'location' => 'Gelora Bung Karno Stadium, Jakarta',
                'event_date' => '2026-08-20 19:00:00',
                'price' => 1500000,
                'quota' => 50000,
            ],
            [
                'title' => 'TechConf Indonesia 2026',
                'description' => 'Konferensi teknologi terbesar di Indonesia. Speakers dari Google, Microsoft, dan startup unicorn lokal. Topik: AI, Cloud Computing, Blockchain, dan Web3. Termasuk workshop dan networking session.',
                'location' => 'The Westin Jakarta, Jakarta',
                'event_date' => '2026-09-10 09:00:00',
                'price' => 500000,
                'quota' => 1000,
            ],
            [
                'title' => 'Persija vs Persib - Derby Klasik',
                'description' => 'Pertandingan klasik Indonesia antara Persija Jakarta vs Persib Bandung. Derby paling dinanti tahun ini! Dukung tim favoritmu di stadion.',
                'location' => 'Stadion Utama GBK, Jakarta',
                'event_date' => '2026-07-05 15:30:00',
                'price' => 150000,
                'quota' => 30000,
            ],
            [
                'title' => 'Stand Up Comedy: Raditya Dika',
                'description' => 'Special show Raditya Dika dengan materi baru. Dijamin ngakak! Show durasi 90 menit dengan cerita-cerita kocak tentang kehidupan, relationship, dan observasi sehari-hari.',
                'location' => 'Teater Jakarta, Taman Ismail Marzuki',
                'event_date' => '2026-07-25 20:00:00',
                'price' => 250000,
                'quota' => 500,
            ],
            [
                'title' => 'Bali Food Festival 2026',
                'description' => 'Festival kuliner terbesar di Bali. 100+ booth makanan tradisional dan modern. Live music, cooking demo oleh chef ternama, dan food competition. Cocok untuk keluarga!',
                'location' => 'Garuda Wisnu Kencana, Bali',
                'event_date' => '2026-08-01 10:00:00',
                'price' => 100000,
                'quota' => 10000,
            ],
            [
                'title' => 'Dewa 19 Reunion Concert',
                'description' => 'Konser reuni Dewa 19 dengan formasi lengkap. Nostalgia lagu-lagu hits 90an dan 2000an: Kangen, Sempurna, Kamulah Satu-satunya, dan masih banyak lagi!',
                'location' => 'ICE BSD, Tangerang',
                'event_date' => '2026-07-30 19:00:00',
                'price' => 500000,
                'quota' => 8000,
            ],
            [
                'title' => 'Startup Founder Meetup Surabaya',
                'description' => 'Networking event untuk startup founders dan entrepreneur. Panel discussion tentang fundraising, product development, dan scaling business. Free snacks dan coffee!',
                'location' => 'CoHive 101 Surabaya',
                'event_date' => '2026-07-12 14:00:00',
                'price' => 50000,
                'quota' => 200,
            ],
            [
                'title' => 'Ultra Music Festival Bali',
                'description' => 'EDM festival terbesar di Asia! Lineup: Martin Garrix, David Guetta, Armin van Buuren, dan DJ lokal terbaik. 2 stages, 12 hours non-stop music!',
                'location' => 'Garuda Wisnu Kencana, Bali',
                'event_date' => '2026-09-05 16:00:00',
                'price' => 2000000,
                'quota' => 15000,
            ],
            [
                'title' => 'Yoga Festival Indonesia',
                'description' => 'Festival yoga dan wellness selama 3 hari. Kelas yoga, meditasi, sound healing, healthy food market, dan workshop kesehatan. Cocok untuk semua level, dari pemula hingga advanced.',
                'location' => 'Ubud, Bali',
                'event_date' => '2026-08-15 07:00:00',
                'price' => 350000,
                'quota' => 500,
            ],
            [
                'title' => 'Prambanan Jazz 2026',
                'description' => 'Konser jazz dengan background Candi Prambanan yang megah. Setting outdoor dengan sunset view yang indah. Featuring musisi jazz Indonesia dan manca negara.',
                'location' => 'Candi Prambanan, Yogyakarta',
                'event_date' => '2026-08-10 17:00:00',
                'price' => 400000,
                'quota' => 3000,
            ],
            [
                'title' => 'Comic Con Indonesia 2026',
                'description' => 'Pop culture convention terbesar! Cosplay competition, celebrity meet & greet, exclusive merchandise, gaming tournament, dan panel discussion dengan creator favorit.',
                'location' => 'JCC Senayan, Jakarta',
                'event_date' => '2026-09-20 10:00:00',
                'price' => 150000,
                'quota' => 20000,
            ],
            [
                'title' => 'Marathon Jakarta 2026',
                'description' => 'Marathon internasional dengan rute melewati landmark Jakarta. Kategori: 5K, 10K, Half Marathon, dan Full Marathon. Finisher medal dan certificate untuk semua peserta!',
                'location' => 'Bundaran HI, Jakarta',
                'event_date' => '2026-10-15 05:00:00',
                'price' => 200000,
                'quota' => 10000,
            ],
            [
                'title' => 'Tulus Live in Concert',
                'description' => 'Konser akustik Tulus dengan band lengkap. Menampilkan lagu-lagu hits: Hati-Hati di Jalan, Sepatu, Monokrom, dan lagu dari album terbaru. Intimate venue dengan sound system premium.',
                'location' => 'The Kasablanka Hall, Jakarta',
                'event_date' => '2026-08-25 20:00:00',
                'price' => 600000,
                'quota' => 2000,
            ],
            [
                'title' => 'Bandung Coffee Festival',
                'description' => 'Festival kopi untuk para coffee enthusiast. Cupping session, barista competition, coffee brewing workshop, dan 50+ booth dari roaster dan cafe terbaik se-Indonesia.',
                'location' => 'Trans Studio Mall Bandung',
                'event_date' => '2026-07-18 10:00:00',
                'price' => 75000,
                'quota' => 5000,
            ],
        ];

        foreach ($events as $eventData) {
            Event::create([
                'title' => $eventData['title'],
                'slug' => Str::slug($eventData['title']) . '-' . uniqid(),
                'description' => $eventData['description'],
                'location' => $eventData['location'],
                'event_date' => $eventData['event_date'],
                'price' => $eventData['price'],
                'quota' => $eventData['quota'],
                'available_quota' => $eventData['quota'],
                'created_by' => $admin->id,
            ]);
        }
    }
}
