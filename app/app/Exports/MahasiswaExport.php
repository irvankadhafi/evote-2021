<?php

namespace App\Exports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;

class MahasiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $mhsModel = new Mahasiswa();
        $data['mahasiswa']=$mhsModel->orderBy('id_kelas')
            ->get()
            ->transform(function ($mahasiswa) {
                return [
                    'nim' => $mahasiswa->nim,
                    'name' => $mahasiswa->name,
                    'email' => $mahasiswa->email,
                    'kelas' => $mahasiswa->kelas->name,
                    'prodi' => $mahasiswa->kelas->prodi->name,
                    'token'=>$mahasiswa->token,
                ];
            });
        return $data['mahasiswa'];
    }
}
