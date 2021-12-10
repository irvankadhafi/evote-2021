<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\ProgramStudi;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KelasController extends Controller
{
    public function index()
    {
        $data = [
            'kelas'=> Kelas::filter(\Illuminate\Support\Facades\Request::only('search','angkatan','prodi'))
                ->paginate(5)
                ->transform(function ($kelas) {
                    return [
                        'id' => $kelas->id,
                        'name' => $kelas->name,
                        'prodi' => $kelas->prodi->name,
                        'status'=>$kelas->status
                    ];
                }),
            'kelas_aktif'=>Kelas::where('status',1)->filter(\Illuminate\Support\Facades\Request::only('search','angkatan','prodi'))->paginate()
                ->transform(function ($kelas) {
                    return [
                        'id' => $kelas->id,
                        'name' => $kelas->name,
                        'prodi' => $kelas->prodi->name,
                    ];
                }),
            'program_studi' => ProgramStudi::with('kelas')->get()
                ->transform(function ($prodi) {
                    return [
                        'id' => $prodi->id,
                        'name' => $prodi->name,
                        'kelas' => $prodi->kelas
                    ];
                }),
        ];
        return Inertia::render('Pemilih/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search','angkatan','prodi'),
            'kelas'=> $data['kelas'],
            'kelas_aktif'=>$data['kelas_aktif'],
        ]);
    }

    public function activeLists()
    {
        return Inertia::render('Pemilih/Active', [
            'filters' => \Illuminate\Support\Facades\Request::all('search','angkatan','prodi'),
            'kelas'=> Kelas::where('status',1)->filter(\Illuminate\Support\Facades\Request::only('search','angkatan','prodi'))->paginate()
                ->transform(function ($kelas) {
                    return [
                        'id' => $kelas->id,
                        'name' => $kelas->name,
                        'prodi' => $kelas->prodi->name,
                    ];
                })
        ]);
    }

    public function activeStatus($id=null)
    {
        if (isset($id)){
            Kelas::where('status',0)->where('id',$id)->update([
                'status' => 1
            ]);
        }else{
            Kelas::where('status',0)->update([
                'status' => 1
            ]);
        }
        return redirect()->route('pemilih')->with('success', 'Berhasil diaktifkan');
    }

    public function activeStatus2(Request $request)
    {
        $prodi = $request->route('prodi');
        if (isset($prodi)){
            Kelas::where('status',0)->where('id_prodi',$prodi)->update([
                'status' => 1
            ]);
        }
        return redirect()->route('pemilih')->with('success', 'Berhasil diaktifkan');
    }
    public function deactiveStatus($id=null)
    {
        if (isset($id)){
            Kelas::where('status',1)->where('id',$id)->update([
                'status' => 0
            ]);
        }else{
            Kelas::where('status',1)->update([
                'status' => 0
            ]);
        }
        return redirect()->route('pemilih')->with('success', 'Berhasil dinonaktifkan');
    }
}
