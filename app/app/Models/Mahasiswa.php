<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='mahasiswa';
    protected $primaryKey = 'nim';
    protected $guarded ='nim';
    protected $keyType = 'string';
    protected $fillable = [
        'nim',
        'name',
        'email',
        'status',
        'id_kandidat',
        'id_kelas',
        'token',
    ];
    public function kelas(){
        return $this->belongsTo(Kelas::class, "id_kelas","id");
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }})
        ->when($filters['status'] ?? null, function ($query, $status) {
            if ($status === 'sudah') {
                $query->where('status',1)->whereNotNull('id_kandidat');
            } elseif ($status === 'belum') {
                $query->where('status',0)->whereNull('id_kandidat');
                }})
        ->when($filters['kelas'] ?? null, function ($query, $kelas) {
            $kelas = Kelas::select('id')->where('name','=',$kelas)->first();
            $query->where('id_kelas',$kelas['id']);})
        ->when($filters['prodi'] ?? null, function ($query, $idProdi) {
            $query->with('kelas')->whereHas('kelas',function ($query) use ($idProdi){
                $query->where('id_prodi','=',$idProdi);
            })->get();})
        ->when($filters['status'] ?? null, function ($query, $statusPilih) {
            if ($statusPilih === 1) {
                $query->withTrashed();
            } elseif ($statusPilih === 0) {
                $query->onlyTrashed();
            }})
        ->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%'.$search.'%')->orWhere('nim', 'like', '%'.$search.'%');
            });
    }
}
