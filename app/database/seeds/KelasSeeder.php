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
        // KELAS 1
        $kelas = new Kelas();
        $kelas->name = "1A-TKI";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1B-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1C-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1A-ANK";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1B-ANK";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1A-TKPB";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "1B-TKPB";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        // KELAS 2
        $kelas = new Kelas();
        $kelas->name = "2A-TKI";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2B-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2C-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2A-ANK";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2B-ANK";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "2-TKPB";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        // KELAS 3
        $kelas = new Kelas();
        $kelas->name = "3A-TKI";
        $kelas->status=0;
        $kelas->id_prodi = 24401;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3B-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3C-TKI";
        $kelas->id_prodi = "24401";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3-ANK";
        $kelas->id_prodi = "24402";
        $kelas->status=0;
        $kelas->save();

        $kelas = new Kelas();
        $kelas->name = "3-TKPB";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();

        // Kelas 4
        $kelas = new Kelas();
        $kelas->name = "4-TKPB";
        $kelas->id_prodi = "24301";
        $kelas->status=0;
        $kelas->save();
    }
}
