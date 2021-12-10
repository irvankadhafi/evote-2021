<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = new Mahasiswa();
        $kelas->nim = "201424004";
        $kelas->name = "Akmal Bachtiar";
        $kelas->email = "akmal.bachtiar.tkpb20@polban.ac.id";
        $kelas->status= 0;
        $kelas->id_kelas =  Kelas::query()->where('name','1A')->first()->id;
        $kelas->save();

        $kelas = new Mahasiswa();
        $kelas->nim = "201424005";
        $kelas->name = "Anjasmara";
        $kelas->email = "anjasmara.tkpb20@polban.ac.id";
        $kelas->status= 0;
        $kelas->id_kelas =  Kelas::query()->where('name','1A')->first()->id;
        $kelas->save();
    }
}
