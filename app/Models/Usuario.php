<?php
/*
 * Copyright (c) 2021.  modem.ff@gmail.com | Marco Antonio Gutierrez Beltran
 */
namespace App\Models;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
/**
 * @method static where(string $string, string $string1, $id)
 */
class Usuario extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    use HasRoles;
    Protected $guard_name ='api'; // added
    protected $primaryKey = 'idUsuario';
    protected $hidden = array('pivot','password', 'remember_token');
    protected $casts      = [
		'estado' => 'boolean',
	];
    protected $fillable = [
        'email',
        'password',
        'tipo_usuario',
        'fecha_ingreso',
        'fecha_baja',
        'liquidacion',
        'profesion',
        'referencia',
        'persona_id',
        'estado'
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
