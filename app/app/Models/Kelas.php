<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table='kelas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'id_prodi',
        'status',
    ];

    public function prodi(){
        return $this->belongsTo(ProgramStudi::class,"id_prodi");
    }
    public function mahasiswa(){
        return $this->hasMany(Mahasiswa::class,"id");
    }

    public function scopeFilter($query, array $filters)
    {
        $query
            ->when($filters['angkatan'] ?? null, function ($query, $kelas) {
                $query->where('name','like', $kelas.'%');
            })
            ->when($filters['prodi'] ?? null, function ($query, $idProdi) {
                $query->whereHas('prodi',function ($query) use ($idProdi){
                    $query->where('id','=',$idProdi);
                })->get();;
            })
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', '%'.$search.'%')->orWhereHas('prodi',function ($query) use ($search){
                    $query->where('name', 'like', '%'.$search.'%');
                });
            });
    }
}
