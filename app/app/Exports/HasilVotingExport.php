<?php

namespace App\Exports;

use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;

class HasilVotingExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('xml', [
            'data' => $this->data
        ]);
    }
}
