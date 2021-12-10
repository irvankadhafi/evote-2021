<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;

class MahasiswaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Mahasiswa([
            'nim'     => $row[2],
            'name'     => $row[1],
            'email'     => $row[3],
            'token' => $this->generateRandomString(6),
            'id_kelas'     => Kelas::query()->where('name',$row[4])->first()->id
        ]);
    }
    function generateRandomString($length = 10) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
