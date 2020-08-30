<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Helpers\FicherosHelper;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Crear subcarpeta específica del usuario bajo una ruta si no existe
     * 
     * @param string $ruta Ruta bajo la que crear la carpeta del usuario
     * @param integer $permisos Permisos para la subcarpeta. Por defecto 0777
     *
     * @return boolean
     */
    public function crearSubcarpeta($ruta, $permisos = 0777)
    {
        return FicherosHelper::crearSubcarpetaUsuario($this->id, $ruta, $permisos);
    }

    /**
     * Crear subcarpeta de imagen del perfil si no existe
     * 
     * @param integer $permisos Permisos para la subcarpeta. Por defecto 0777
     * 
     * @return boolean
     */
    public function crearSubcarpetaImagenPerfil($permisos = 0777)
    {
        return $this->crearSubcarpeta(FicherosHelper::getRutaImagenesPerfilUsuarios(), $permisos);
    }

    /**
     * Obtiene la ruta del fichero de imagen del perfil del usuario según su tamaño
     * 
     * @param string $tam El tamaño del fichero de imagen ('min', 'med', 'max')
     * @param boolean $validar Validar si el fichero existe. Por defecto 'true'
     * 
     * @return string
     */
    public function getRutaImagenPerfil($tam = FicherosHelper::SUFIJO_IMAGEN_MAX, $validar = true)
    {
        return FicherosHelper::getRutaImagenPerfilUsuario($this->id, $tam, $validar);
    }
}
