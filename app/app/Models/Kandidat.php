<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use League\Glide\Server;

class Kandidat extends Model
{
    use HasFactory;
    use  Authenticatable, Authorizable;
    protected $table = 'kandidat';
    protected $primaryKey='id';
    protected $fillable = [
        'name',
        'visi',
        'misi',
        'photo_path'
    ];
    public function photoUrl(array $attributes)
    {
        if ($this->photo_path) {
            return URL::to(App::make(Server::class)->fromPath($this->photo_path, $attributes));
        }
    }
}
