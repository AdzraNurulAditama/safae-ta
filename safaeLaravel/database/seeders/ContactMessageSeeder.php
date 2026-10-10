<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ContactMessage;

class ContactMessageSeeder extends Seeder
{
    public function run()
    {
        ContactMessage::create([
            'name' => 'Adzra Nurul Aditama',
            'email' => 'adzra@example.com',
            'message' => 'Halo admin, saya mau tanya tentang fitur baru di Safae!',
        ]);

        ContactMessage::create([
            'name' => 'User Random',
            'email' => 'randomuser@gmail.com',
            'message' => 'Website Safae bagus banget, semangat terus yaa!',
        ]);

        ContactMessage::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'message' => 'Saya menemukan bug saat baca cerita, bisa dicek?',
        ]);
    }
}
