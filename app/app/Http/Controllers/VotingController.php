<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Illuminate\Support\Facades\Session;

class VotingController extends Controller
{
    public function index()
    {
        return Inertia::render('Home/Index');
    }

    public function login(Request $request, Mahasiswa $mahasiswa)
    {
        $data['statusLogin']=false;
        $this->validate($request, [
            'nim' => 'required',
            'token' => 'required'
        ]);
        $mhs = $mahasiswa->find($request->nim);
        if ($mhs){
            if ($mhs->token == $request->token){
                $request->session()->put('nim',$mhs->nim);
                $request->session()->put('login-voting',TRUE);
                return Redirect::route('voting.info')->with('statusLogin',true);
            }else{
                return redirect()->back()->with('error', 'Gagal Login Karena Token Salah');
            }
        }else{
            return redirect()->back()->with('error', 'Gagal Login Karena NIM Salah');
        }
    }

    public function infoLogin()
    {
        $mahasiswa = Mahasiswa::find(session()->get('nim'));
        $data['mahasiswa'] = [
            'nim'=>$mahasiswa->nim,
            'name'=>$mahasiswa->name,
            'kelas'=>$mahasiswa->kelas->name,
            'prodi'=>$mahasiswa->kelas->prodi->name,
            'status_mhs'=> $mahasiswa->status,
            'status_kls'=>$mahasiswa->kelas->status
        ];
        $data['kandidat'] = Kandidat::all()->transform(function ($kandidat) {
            return [
                'id' => $kandidat->id,
                'name' => $kandidat->name,
                'visi' => $kandidat->visi,
                'misi' => $kandidat->misi,
                'foto' => $kandidat->photoUrl(['w' => 800, 'h' => 800, 'fit' => 'crop']),
            ];
        });
        return Inertia::render('Home/Info',$data);
    }
    public function listKandidat()
    {
        $mahasiswa = Mahasiswa::find(session()->get('nim'));
        $data['mahasiswa'] = [
            'nim'=>$mahasiswa->nim,
            'name'=>$mahasiswa->name,
            'kelas'=>$mahasiswa->kelas->name,
            'prodi'=>$mahasiswa->kelas->prodi->name,
            'status_mhs'=> $mahasiswa->status,
            'status_kls'=>$mahasiswa->kelas->status
        ];
        $data['kandidat'] = Kandidat::all()->transform(function ($kandidat) {
            return [
                'id' => $kandidat->id,
                'name' => $kandidat->name,
                'visi' => $kandidat->visi,
                'misi' => $kandidat->misi,
                'foto' => $kandidat->photoUrl(['w' => 800, 'h' => 800, 'fit' => 'crop']),
            ];
        });
        if($data['mahasiswa']['status_kls']==0){
            return Redirect::route('voting.info');
        }
        return Inertia::render('Home/Kandidat',$data);
    }

    public function pilih(Request $request, Mahasiswa $mahasiswa)
    {
        $this->validate($request, [
            'nim' => 'required',
            'kandidat_id' => 'required'
        ]);
        $idKandidat = $request->kandidat_id;
        $mhs = $mahasiswa->find(Session::get('nim'));
        $data = [
            'nim'                   =>$mhs->nim,
            'name'                  =>$mhs->name,
            'id_kandidat'           =>$mhs->id_kandidat,
            'status_pilih_mahasiswa'=>$mhs->status,
            'status_pilih_kelas'    =>$mhs->kelas->status
        ];
        if($data['status_pilih_kelas']==1){
            if ($data['status_pilih_mahasiswa'] == 0 && $data['id_kandidat'] == null){
                $mhs->update([
                    'id_kandidat' => $idKandidat,
                    'status'=> 1
                ]);
                return redirect()->back()
                    ->with('success', 'Berhasil memilih nomor urut '.$idKandidat);
            }else{
                return redirect()->back()
                    ->with('error', 'Kamu sudah memilih');
            }
        }else{
            return redirect()->back()
                ->with('error', 'Kelas kamu belum boleh memilih');
        }
    }

    public function kandidatProfile()
    {
        $data['kandidat'] = Kandidat::all()->transform(function ($kandidat) {
            return [
                'id' => $kandidat->id,
                'name' => $kandidat->name,
                'visi' => $kandidat->visi,
                'misi' => $kandidat->misi,
                'foto' => $kandidat->photoUrl(['w' => 800, 'h' => 800, 'fit' => 'crop']),
            ];
        });
        return Inertia::render('Home/KandidatProfile',$data);
    }
    public function resumeData(Request $request)
    {
        $url = url()->previous();
        $prevRoute = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $data['prevPage']=$prevRoute;
        $mahasiswa = Mahasiswa::find(session()->get('nim'));
        $data['mahasiswa'] = [
            'status_mhs'=> $mahasiswa->status,
            'status_kls'=>$mahasiswa->kelas->status
        ];
        $nomor=$request->nomor;
        $data['kandidat'] = Kandidat::where('id',$nomor)->first();
        return Inertia::render('Home/Dokumen',$data);
    }

    public function visimisiData(Request $request)
    {
        $url = url()->previous();
        $prevRoute = app('router')->getRoutes($url)->match(app('request')->create($url))->getName();
        $data['prevPage']=$prevRoute;
        $mahasiswa = Mahasiswa::find(session()->get('nim'));
        $data['mahasiswa'] = [
            'status_mhs'=> $mahasiswa->status,
            'status_kls'=>$mahasiswa->kelas->status
        ];
        $nomor=$request->nomor;
        $data['kandidat'] = Kandidat::where('id',$nomor)->first();
        return Inertia::render('Home/VisiMisi',$data);
    }

    public function logout()
    {
        session()->forget('login-voting');
        session()->forget('nim');
        return Redirect::route('voting.home');
    }
}
