<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;

class FicherosHelper
{
    const SUFIJO_IMAGEN_MIN = 'min';
    const SUFIJO_IMAGEN_MED = 'med';
    const SUFIJO_IMAGEN_MAX = 'max';

    /**
     * Obtiene la ruta de los ficheros de imagenes estáticas
     * 
     * @return string
     */
    public static function getRutaImagenes()
    {
        return config('personalizada.ruta_imagenes');
    }

    /**
     * Obtiene la ruta del fichero de imagen del perfil de usuario por defecto.
     *
     * @return string
     */
    public static function getRutaImagenPerfilUsuarioDefecto()
    {
        return self::getRutaImagenes() . '/' . config('personalizada.imagen_perfil_usuario_defecto');
    }

    /**
     * Obtiene la ruta de los ficheros de imágenes del perfil subidas por los usuarios
     * 
     * @return string
     */
    public static function getRutaImagenesPerfilUsuarios() 
    {
        return config('personalizada.ruta_imagenes_perfil_usuarios');
    }

    /**
     * Obtiene una cadena formateada con el ID del usuario para definir carpetas y ficheros
     * 
     * @param integer $userId El ID del usuario
     * 
     * @return string
     */
    public static function getCadenaIdUsuarioFicheros($userId)
    {
        return str_pad($userId, 10, '0', STR_PAD_LEFT);
    }

    /**
     * Obtiene el nombre de un fichero de imagen del perfil de un usuario según su tamaño
     * 
     * @param integer $userId El ID del usuario
     * @param string $tam El tamaño del fichero de imagen ('min', 'med', 'max')
     * @param string $extension Extension del fichero. Por defecto 'jpg'
     * 
     * @return string
     */
    public static function getNombreFicheroImagenPerfilUsuario($userId, $tam = self::SUFIJO_IMAGEN_MAX, $extension = 'jpg')
    {
        $nombreFichero = null;

        if (is_int($userId) && $userId > 0) {
            $nombreFichero = self::getCadenaIdUsuarioFicheros($userId) . '-' . $tam . '.' . $extension;
        }

        return $nombreFichero;
    }

    /**
     * Crear subcarpeta específica del usuario bajo una ruta si no existe
     * 
     * @param integer $userId El ID del usuario
     * @param string $ruta Ruta bajo la que crear la carpeta del usuario
     * @param integer $permisos Permisos para la subcarpeta. Por defecto 0777
     *
     * @return boolean
     */
    public static function crearSubcarpetaUsuario($userId, $ruta, $permisos = 0777)
    {
        $ok = true;

        try {
            $rutaUsuario = public_path($ruta . '/' . self::getCadenaIdUsuarioFicheros($userId));
            if(!File::isDirectory($rutaUsuario)) {
                File::makeDirectory($rutaUsuario, $permisos, true);
            }
        } catch (\Throwable $e) {
            $ok = false;
            report($e);
        } finally {
            return $ok;
        }
    }

    /**
     * Obtiene la ruta del fichero de imagen del perfil de un usuario según su tamaño
     * 
     * @param integer $userId El ID del usuario
     * @param string $tam El tamaño del fichero de imagen ('min', 'med', 'max')
     * @param boolean $validar Validar si el fichero existe. Por defecto 'true'
     * 
     * @return string
     */
    public static function getRutaImagenPerfilUsuario($userId, $tam = self::SUFIJO_IMAGEN_MAX, $validar = true)
    {
        $rutaFichero = self::getRutaImagenPerfilUsuarioDefecto();
        $nombreFichero = self::getNombreFicheroImagenPerfilUsuario($userId, $tam);
        
        if ($nombreFichero) {
            $rutaFicheroAux = self::getRutaImagenesPerfilusuarios() . '/' . 
                self::getCadenaIdUsuarioFicheros($userId) . '/' . $nombreFichero;
            $rutaFicheroCompletaAux = public_path($rutaFicheroAux);
            if (($validar && file_exists($rutaFicheroCompletaAux)) || !$validar) { 
                $rutaFichero = $rutaFicheroAux;
            }
        }

        return $rutaFichero;
    }
}