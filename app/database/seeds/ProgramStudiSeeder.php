<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $prodi = new ProgramStudi();
        $prodi->id = 24401;
        $prodi->name = "D3-Teknik Kimia";
        $prodi->save();

        $prodi = new ProgramStudi();
        $prodi->id = 24402;
        $prodi->name = "D3-Analis Kimia";
        $prodi->save();

        $prodi = new ProgramStudi();
        $prodi->id = 24301;
        $prodi->name = "D4-Teknik Kimia Produksi Bersih";
        $prodi->save();
    }
}
