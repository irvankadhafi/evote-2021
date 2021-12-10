<?php

namespace App\Http\Controllers;

use App\Exports\HasilVotingExport;
use App\Models\Kandidat;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Handler\AbstractHandler;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard/Index');
    }
    public function hasil()
    {
        $data['info']=[
            'total_mahasiswa' => Mahasiswa::all()->count(),
            'belum_memilih'=>Mahasiswa::select(DB::raw('COUNT(nim) as jumlah'))
                ->where('status',0)
                ->whereNull('id_kandidat')
                ->first()->jumlah,
            'sudah_memilih'=>Mahasiswa::select(DB::raw('COUNT(nim) as jumlah'))
                ->where('status',1)
                ->whereNotNull('id_kandidat')
                ->first()->jumlah,
            'total_kelas'=>Kelas::all()->count()
        ];
        $data['hasil'] = Mahasiswa::select(DB::raw('COUNT(mahasiswa.id_kandidat) as jumlah'),'kandidat.name')
            ->join('kandidat','kandidat.id','=','mahasiswa.id_kandidat','RIGHT')
            ->groupBy('kandidat.id')
            ->get();
        $hasil=['label'=>[],'jumlah'=>[]];
        foreach ($data['hasil'] as $item){
            array_push($hasil['label'],$item['name']);
            array_push($hasil['jumlah'],$item['jumlah']);
        }
        $data['hasil']=$hasil;

        //Menghitung data per angkatan
        $perAngkatan=$this->hasilPerAngkatan();
        foreach ($perAngkatan as $key=>$item){
            $data[$key]=[
                'label'=>array_keys($item),
                'jumlah'=>array_values($item)
            ];
        }
        return Inertia::render('Dashboard/Hasil',$data);
    }
    public function hasilPerAngkatan()
    {
        $kandidatName=Kandidat::get('name');
        foreach ($kandidatName as $key=>$item){
            $hasil['angkatan1'][$item['name']] = Mahasiswa::whereHas('kelas',function ($query){
                $query->where('name','like','1%');
            })->where('id_kandidat',$key+1)->get()->count();

            $hasil['angkatan2'][$item['name']] = Mahasiswa::whereHas('kelas',function ($query){
                $query->where('name','like','2%');
            })->where('id_kandidat',$key+1)->get()->count();

            $hasil['angkatan3'][$item['name']] = Mahasiswa::whereHas('kelas',function ($query){
                $query->where('name','like','3%');
            })->where('id_kandidat',$key+1)->get()->count();

            $hasil['angkatan4'][$item['name']] = Mahasiswa::whereHas('kelas',function ($query){
                $query->where('name','like','4%');
            })->where('id_kandidat',$key+1)->get()->count();
        }
        return  $hasil;
    }

    public function dataExport()
    {
        $data['hasil'] = Mahasiswa::select(DB::raw('COALESCE(COUNT(mahasiswa.id_kandidat)) as jumlah'),'kandidat.name')
            ->join('kandidat','kandidat.id','=','mahasiswa.id_kandidat','RIGHT')
            ->groupBy('kandidat.id')
            ->get();
        $hasil=['label'=>[],'jumlah'=>[]];
        foreach ($data['hasil'] as $item){
            array_push($hasil['label'],$item['name']);
            array_push($hasil['jumlah'],$item['jumlah']);
        }
        $data['hasil']=$hasil;

        //Menghitung data per angkatan
        $perAngkatan=$this->hasilPerAngkatan();
        foreach ($perAngkatan as $key=>$item){
            $data[$key]=[
                'label'=>array_keys($item),
                'jumlah'=>array_values($item)
            ];
        }
        return $data;
    }
    public function export()
    {
        //Menghitung data per angkatan
        $perAngkatan=$this->hasilPerAngkatan();
        foreach ($perAngkatan as $key=>$item){
            $data[$key]=[
                'jumlah'=>array_values($item)
            ];
        }

        $data = [
            [
                'Angkatan' => 'Kelas 1',
                'Calon 1' => $data['angkatan1']['jumlah'][0],
                'Calon 2' => $data['angkatan1']['jumlah'][1],
                'Calon 3' => $data['angkatan1']['jumlah'][2],
            ],
            [
                'Angkatan' => 'Kelas 2',
                'Calon 1' => $data['angkatan2']['jumlah'][0],
                'Calon 2' => $data['angkatan2']['jumlah'][1],
                'Calon 3' => $data['angkatan2']['jumlah'][2],
            ],
            [
                'Angkatan' => 'Kelas 3',
                'Calon 1' => $data['angkatan3']['jumlah'][0],
                'Calon 2' => $data['angkatan3']['jumlah'][1],
                'Calon 3' => $data['angkatan3']['jumlah'][2],
            ],
            [
                'Angkatan' => 'Kelas 4',
                'Calon 1' => $data['angkatan4']['jumlah'][0],
                'Calon 2' => $data['angkatan4']['jumlah'][1],
                'Calon 3' => $data['angkatan4']['jumlah'][2],
            ],
        ];
        return Excel::download(new HasilVotingExport($data), 'hasil_voting.xlsx');
    }
}
