<?php

namespace Database\Seeders;

use App\Models\Kandidat;
use Illuminate\Database\Seeder;

class KandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kandidat = new Kandidat();
        $kandidat->name = "Irvan Kadhafi";
        $kandidat->visi = "Mantap";
        $kandidat->misi = "Salut";
        $kandidat->foto = "test.jpg";
        $kandidat->save();

        $kandidat = new Kandidat();
        $kandidat->name = "Rezky Wahyuda";
        $kandidat->visi = "Mantap";
        $kandidat->misi = "Salut";
        $kandidat->foto = "test.jpg";
        $kandidat->save();

        $kandidat = new Kandidat();
        $kandidat->name = "Ikhsan Setiawan";
        $kandidat->visi = "Mantap";
        $kandidat->misi = "Salut";
        $kandidat->foto = "test.jpg";
        $kandidat->save();
    }
}
