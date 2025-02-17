<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compte extends Model
{
    use HasFactory;

    protected $fillable = ['login', 'mot_passe', 'profil'];

    protected $hidden = ['mot_passe'];

    public function setMotPasseAttribute($value)
    {
        $this->attributes['mot_passe'] = bcrypt($value);
    }
}
