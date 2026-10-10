<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookUserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('bookuser')->insert([
            [
                'title' => 'KKN di Desa Penari',
                'author' => 'Simpelman',
                'genre' => 'Horor',
                'year' => '2023',
                'cover_image' => 'images/kkn.jpeg',
                'synopsis' => 'Pada suatu sore, enam mahasiswa dari sebuah universitas di Jawa Timur bersiap melakukan Kuliah Kerja Nyata (KKN). Mereka adalah Nur, Widya, Ayu, Bima, Wahyu, dan Anton. Setelah beberapa hari briefing di kampus, mereka berangkat menuju sebuah desa terpencil yang direkomendasikan oleh dosen pembimbing. Desa itu tidak ada dalam daftar KKN sebelumnya, tetapi ditawarkan oleh seseorang yang dikenal dosen.',
                'full_text' => "Pada suatu sore, enam mahasiswa dari sebuah universitas di Jawa Timur bersiap melakukan Kuliah Kerja Nyata (KKN). Mereka adalah Nur, Widya, Ayu, Bima, Wahyu, dan Anton. Setelah beberapa hari briefing di kampus, mereka berangkat menuju sebuah desa terpencil yang direkomendasikan oleh dosen pembimbing. Desa itu tidak ada dalam daftar KKN sebelumnya, tetapi ditawarkan oleh seseorang yang dikenal dosen. Perjalanan menuju desa cukup sulit. Mereka harus menyeberang hutan, melewati jalan berbatu, dan akhirnya sampai di sebuah desa yang terlihat kuno dan sepi, namun bersih dan tertata. Kepala desa menyambut mereka dengan ramah, namun dengan sedikit kekakuan. Mereka tinggal di rumah warga yang sudah disiapkan. Namun, dari awal, Nur—gadis religius dan sensitif terhadap hal gaib—merasa ada yang tidak beres. Ia mencium aroma bunga melati dan mendengar suara gamelan jauh di malam hari, padahal desa itu sangat sepi. Mereka mulai melaksanakan tugas KKN, mengajar anak-anak desa, membantu warga member.\n
Malam kedua berjalan dengan tenang, namun Nur kembali mendengar gamelan yang sama. Ia terbangun dan melihat bayangan hitam di depan rumah. Ketika ia mencoba membangunkan teman-temannya, suara itu berhenti. Esoknya, ia menanyakan kepada kepala desa, tapi kepala desa hanya diam dan berkata, 'Jangan keluar malam-malam, Nak.'\n
Hari-hari berikutnya semakin aneh. Widya bermimpi tentang wanita berpakaian putih di tepi sungai. Bima tiba-tiba jatuh sakit tanpa sebab. Sementara itu, Wahyu menemukan sesajen di belakang rumah mereka. Mereka mulai menyadari bahwa desa itu menyimpan rahasia besar.\n
Mereka akhirnya mengetahui bahwa desa itu dulu pernah ditinggali oleh seorang dukun wanita yang meninggal dengan tidak wajar. Arwahnya dipercaya masih gentayangan dan menuntut balas. Para mahasiswa berusaha melawan rasa takut, tapi satu per satu kejadian mistis mulai mengancam nyawa mereka...",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Negeri Para Bedebah',
                'author' => 'Tere Liye',
                'genre' => 'Action',
                'year' => '2020',
                'cover_image' => 'images/negeri-para-bedebah.jpeg',
                'synopsis' => 'Pesawat berbadan besar yang kutumpangi melaju cepat meninggalkan London. Penerbangan ini nonstop menuju Singapura. Gadis dengan rambut dikucir dan seperangkat touchscreen ditangan, berisi corat-coret daftar pertanyaan, tersenyum gugup dikursi berlapis kulit asli di sebelahku.',
                'full_text' => 'Pesawat berbadan besar yang kutumpangi melaju cepat meninggalkan London. Penerbangan ini nonstop menuju Singapura. Gadis dengan rambut dikucir dan seperangkat touchscreen ditangan, berisi corat-coret daftar pertanyaan, tersenyum gugup dikursi berlapis kulit asli di sebelahku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Ken Angrok',
                'author' => 'Pramodya Ananta Toer',
                'genre' => 'History',
                'year' => '1999',
                'cover_image' => 'images/ken-angrok.jpg',
                'synopsis' => 'Kesulitan dana akibat bertubi-tubi diberangus oleh kekuasaan represif rejim Orde Baru menyebabkan "Arok Dedes" ini baru sekarang dapat kami terbitkan. Masih ada tulisan penting lain ditulis Pramoedya di Buru yang kami harapkan bisa menyusul terbit dalam waktu dekat, yaitu satu-satunya karya dalam bentuk drama/sandiwara berjudul "Mangir".',
                'full_text' => 'Kesulitan dana akibat bertubi-tubi diberangus oleh kekuasaan represif rejim Orde Baru menyebabkan "Arok Dedes" ini baru sekarang dapat kami terbitkan. Masih ada tulisan penting lain ditulis Pramoedya di Buru yang kami harapkan bisa menyusul terbit dalam waktu dekat, yaitu satu-satunya karya dalam bentuk drama/sandiwara berjudul "Mangir".',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Hello, Mr Cold',
                'author' => 'Bintang Pelangi',
                'genre' => 'Romance',
                'year' => '2020',
                'cover_image' => 'images/mr-cold.jpg',
                'synopsis' => 'Di musim dingin yang membekukan, Maximilian Cold anak dari keluarga terkaya dan paling ambisius di kota memutuskan untuk mengejar impiannya menjadi pemain terompet.',
                'full_text' => 'Di musim dingin yang membekukan, Maximilian Cold anak dari keluarga terkaya dan paling ambisius di kota memutuskan untuk mengejar impiannya menjadi pemain terompet.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
