<?php

namespace App\Http\Controllers;

use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;

class MahasiswaController extends Controller
{
    public function index()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $mhsModel = new Mahasiswa();
        $klsModel = new Kelas();
        return Inertia::render('Mahasiswa/Index', [
            'filters' => \Illuminate\Support\Facades\Request::all('search','trashed','status','kelas','prodi'),
            'mahasiswa'=> $mhsModel->orderBy('id_kelas')
                ->filter(\Illuminate\Support\Facades\Request::only('search','trashed','status','kelas','prodi'))
                ->paginate(10)
                ->transform(function ($mahasiswa) {
                    return [
                        'nim' => $mahasiswa->nim,
                        'name' => $mahasiswa->name,
                        'email' => $mahasiswa->email,
                        'kelas' => $mahasiswa->kelas,
                        'prodi' => $mahasiswa->kelas->prodi->name,
                        'token'=>$mahasiswa->token,
                        'id_kandidat'=>$mahasiswa->id_kandidat,
                    ];
                }),
            'dataKelas'=>$klsModel->all()
                ->transform(function ($kelas) {
                    return [
                        'id' => $kelas->id,
                        'name' => $kelas->name,
                    ];
                })
        ]);
    }

    public function deleteAll()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        Mahasiswa::truncate();
    }
    public function import(Request $request)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = $file->hashName();

        //temporary file
        $path = $file->storeAs('public/excel/',$nama_file);

        // import data
        $import = Excel::import(new MahasiswaImport(), storage_path('app/public/excel/'.$nama_file));

        //remove from server
        Storage::delete($path);

        if($import) {
            //redirect
            return redirect()->route('mahasiswa')->with('success', 'Data Berhasil Di Import');
        } else {
            //redirect
            return redirect()->route('mahasiswa')->with(['error' => 'Data Gagal Diimport!']);
        }
    }

    public function export()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        return Excel::download(new MahasiswaExport(), 'pemilih.xlsx');
    }
    public function indexImport()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $data = [
            'title' => 'Data Akun Voting',
            'mahasiswa' => Mahasiswa::all()
        ];
        return view('importMahasiswa', $data);
    }

    public function MahasiswaKelas($kelas)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        return Mahasiswa::where('id_kelas',$kelas)->get();
    }

    public function resetAllPilihan()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        Mahasiswa::where('status',1) ->update([
            'status' => 0,
            'id_kandidat'=>null
        ]);
        return redirect()->route('mahasiswa')->with('success', 'Berhasil direset semua');
    }
}
