<?php

namespace App\Http\Controllers;

use App\Models\Kandidat;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class KandidatController extends Controller
{
    public function index()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $kandidatModel = new Kandidat();
        $data = [
            'title' => 'Data Kandidat',
            'kandidat' => $kandidatModel
                ->paginate(5)
                ->transform(function ($kandidat) {
                    return [
                        'id' => $kandidat->id,
                        'name' => $kandidat->name,
                        'visi' => $kandidat->visi,
                        'misi' => $kandidat->misi,
                        'foto' => $kandidat->photoUrl(['fit' => 'crop'])
//                        'deleted_at' => $kandidat->deleted_at,
                    ];
                }),
        ];
        return Inertia::render('Kandidat/Index', [
            'kandidat'=> $data['kandidat']
        ]);
    }

    public function create()
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        return Inertia::render('Kandidat/Create');
    }

    public function store(Request $request)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'foto' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return redirect()->route('kandidat.tambah')->withErrors($validator)->withInput();
        } else {

            $file = $request->file('foto')->store('kandidat');
            Kandidat::create([
                'name' => $request->name,
                'visi' => $request->visi,
                'misi' => $request->misi,
                'photo_path' => $file
            ]);
            return redirect()->route('kandidat')->with('status', 'Berhasil Menambah Kandidat');
        }
    }

    public function edit(Kandidat $kandidat)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        return Inertia::render('Kandidat/Edit', [
            'kandidat' => [
                'id' => $kandidat->id,
                'name' => $kandidat->name,
                'visi' => $kandidat->visi,
                'misi' => $kandidat->misi,
                'foto' => $kandidat->photoUrl(['fit' => 'crop'])
            ],
        ]);
    }

    public function delete(Kandidat $kandidat)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        Storage::disk('public')->delete($kandidat->foto);
        $kandidat->delete();
        return redirect()->route('kandidat')->with('status', 'Berhasil Menghapus Kandidat');
    }

    public function update(Kandidat $kandidat,Request $request)
    {
        if(!Auth::user()->owner){
            return redirect()->route('dashboard.home')->with('error', 'Kamu bukan admin/panita');
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'foto' => ['nullable', 'image'],
        ]);
        if($validator){
            $kandidat->update([
                'name'=>$request->name,
                'visi'=>$request->visi,
                'misi'=>$request->misi
            ]);
            if($request->foto){
                $kandidat->update([
                    'photo_path'=>$request->file('foto')->store('kandidat')
                ]);
            }
        }
        return redirect()->route('kandidat')->with('success', 'Kandidat updated.');
    }
}
