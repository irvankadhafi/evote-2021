<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kelas = new Kelas();
        $kelas->name = "1A";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();


        $kelas = new Kelas();
        $kelas->name = "1B";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1C";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1D";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1E";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2A";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();


        $kelas = new Kelas();
        $kelas->name = "2B";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2C";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2D";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2E";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3A";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();


        $kelas = new Kelas();
        $kelas->name = "3B";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3C";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3D";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3E";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "4D";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();
    }
}
