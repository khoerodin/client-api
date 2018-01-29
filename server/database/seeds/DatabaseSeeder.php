<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Un Guard model
        Model::unguard();

        // disable fk constrain check
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Ask for db migration refresh, default is no
        if ($this->command->confirm('Apakah benar Anda akan melakukan fresh migrasi sebelum melakukan seeding? ini akan membuat ulang semua tabel dan mengahpus semua data yang telah ada.')) {

            // Call the php artisan migrate:refresh using Artisan
            $this->command->call('migrate:fresh');
            $this->command->warn("Database telah dibersihkan, memulai dari database kosong.");

            // Call the passport install
            $this->command->info("Menentukan client Laravel Passprt.");
            $this->command->call('passport:client');
            $this->command->info("Membuat kunci enkripsi Laravel Passprt.");
            $this->command->call('passport:keys');
        }

        // Tentukan jumlah buku dan penulis
        $numberOfBookUser = $this->command->ask('Berapa jumlah buku dan penulis yang diinginkan ?', 20);
        $this->command->info("Membuat {$numberOfBookUser} buku dan {$numberOfBookUser} penulis, setiap buku memiliki satu penulis dan sebaliknya.");

        // Membuat buku dan penulis
        $bookUsers = factory(App\BookUser::class, intval($numberOfBookUser))->create();
        $this->command->info('Buku dan penulis berhasil dibuat!');

        // Berapa chapter pada setiap buku
        $chapterRange = $this->command->ask('Berapa chapter yang dimiliki setiap buku? berikan rentang.', '10-20');

        // membuat chapter dalam buku, sesuai rentang yang diberikan
        $bookUsers->each(function ($bookUser) use ($chapterRange) {
            factory(App\Chapter::class, $this->getRandomRange($chapterRange))
                ->create(['book_id' => $bookUser->book_id]);
        });

        $this->command->warn("Sekarang setiap buku memiliki {$chapterRange} chapter!");

        $this->command->info("Ihirrr! Database telah di-seeding.");

        $this->command->warn('Ini informasi Login yang bisa dicoba.');
        $this->command->info(sprintf('Email: %s dan passwordnya secret.', App\User::inRandomOrder()->first()->email));

        // enable back fk constrain check
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Re Guard model
        Model::reguard();
    }

    /**
     * Return random value in given range
     *
     * @param $chapterRange
     * @return int
     */
    public function getRandomRange($chapterRange)
    {
        return rand(...explode('-', $chapterRange));
    }
}
