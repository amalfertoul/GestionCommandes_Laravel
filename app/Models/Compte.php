<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Compte extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['login', 'mot_passe', 'profil', 'email'];

    protected $hidden = ['mot_passe'];

    public function setMotPasseAttribute($value)
    {
        $this->attributes['mot_passe'] = bcrypt($value);
    }
}
