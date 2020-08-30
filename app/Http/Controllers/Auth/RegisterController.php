<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\FicherosHelper;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data 
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Si hay imagen de perfil cargada, recuperamos los datos codificados en base64
        // y guardamos en varios tamaños
        $request = request();
        if ($request->has('imagen_data') && !empty($request->input('imagen_data'))) {
            $imagenData = str_replace('data:image/jpeg;base64,', '', $request->input('imagen_data'));

            $im = imagecreatefromstring(base64_decode($imagenData));
            // Recuperamos las dimensiones de la imagen (aunque se supone que es cuadrada, y $width == $height)
            $width = imagesx($im);
            $height = imagesy($im);

            // Guardamos en varios tamaños
            for ($x = 1; $x <= 3; $x++) {
                // Asignamos el tamaño de redimensión de la imagen, si corresponde,
                // así como el sufijo para el fichero de imagen
                $tamRedim = 0;
                $sufijoFichero = '';
                if ($x == 1) {
                    $tamRedim = config('personalizada.tam_min_imagen_perfil_usuario');
                    $sufijoFichero = FicherosHelper::SUFIJO_IMAGEN_MIN;
                } elseif ($x == 2) {
                    $tamRedim = config('personalizada.tam_med_imagen_perfil_usuario');
                    $sufijoFichero = FicherosHelper::SUFIJO_IMAGEN_MED;
                } else {
                    $sufijoFichero = FicherosHelper::SUFIJO_IMAGEN_MAX;
                }

                // Si no estamos en la iteración que corresponde al tamaño máximo de imagen
                // tenemos que redimensionar, pero en caso contrario ya la tendríamos en el 
                // tamaño que queremos, y no sería necesario.
                if ($x < 3) {
                    $imRedim = imagecreatetruecolor($tamRedim, $tamRedim);
                    imagecopyresized($imRedim, $im, 0, 0, 0, 0, $tamRedim, $tamRedim, $width, $height);
                } else {
                    $imRedim = $im;
                }
 
                // Guardamos la imagen, en su caso redimensionada, y sin validar que existe 
                // (porque necesitamos precisamente crear el fichero)

                $user->crearSubcarpetaImagenPerfil();
                
                imagejpeg($imRedim, public_path($user->getRutaImagenPerfil($sufijoFichero, false)), 100);
                imagedestroy($imRedim);
            }
        }

        return $user;
    }
}
