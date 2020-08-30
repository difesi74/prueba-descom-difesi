# Prueba Descom

El framework utilizado para el backend ha sido `Laravel 7` para PHP.

En la parte frontend se han utilizado principalmente `jQuery`, `Bootstrap 4` y `Cropper.js`, además de `Font Awesome`.

Sobre el requerimiento inicial de la prueba, que era rellenar un formulario de registro que al ser enviado al servidor remitiese un correo para la activación de la cuenta del usuario, `se han realizado una serie de mejoras` partiendo de la autenticación básica de Laravel, principalmente las siguientes:

- Se ha incluido en el `registro del usuario` la posibilidad de añadir la `imagen del perfil`, cargando un fichero de imagen (.PNG, .JPEG o .JPG) que se puede recortar con ayuda de la librería [Cropper.js](https://github.com/fengyuanchen/jquery-cropper), generándose tras el envío del formularo 3 ficheros .JPG en una carpeta de imágenes del perfil para ese usuario con tamaños: `300x300, 150x150 y 50x50` píxeles. Básicamente se ha conseguido almacenando previamente en el front una `imagen en Base64`, proveniente del recorte del fichero cargado, que se pasa por POST junto al resto de campos al controlador `RegisterController.php`, redimensionándola y guardando los ficheros correspondientes a dicha imagen posteriormente en el servidor.
- Se ha incluido la funcionalidad de `mostrar-ocultar contraseña` en todos los campos de tipo `password` de la aplicación.
- Se han introducido en el front `transiciones y transformaciones con jQuery`, y se han modificado los `estilos CSS de todas las vistas` de la aplicación.

Quedaría pendiente...
- `Gestionar el almacenamiento de los ficheros` subidos por el usuario desde `/storage` en lugar de `/public`, y utilizar los métodos específicos de la clase `Storage` de Laravel. De esa manera se evitarían muchos problemas de permisos porque lo manejaría todo el framework.
- `Personalizar el mail de activación` de la cuenta que se envía al correo del usuario.

En conjunto se entiende que el objetivo inicial de la prueba ha quedado sobradamente cumplido.

Los ficheros más significativos desde el punto de visto de escritura de código y mejoras dentro del proyecto son:

- `app/Helpers/FicherosHelper.php`
- `app/Http/Controllers/RegisterController.php`
- `app/User.php`
- `config/personalizada.php`
- `public/css/mis-estilos.css`
- `public/js/mis-scripts.js`
- `resources/views/*` (todas las vistas)

## Despliegue en localhost

- Copiar `.env.local` a `.env`.
- Cambiar permisos de carpetas mediante `sudo chmod -R 777 storage bootstrap/cache public/subidas`, desde la raíz del proyecto.
- Ejecutar `composer install` desde la raíz del proyecto, para descargar las dependencias de PHP en `/vendor`.
- Ejecutar `npm install & npm run dev` desde la raíz del proyecto, para descargar las dependencias de JS en `/node_modules` y ejecutar la configuración de webpack.
- Crear una BD en MySQL que se llame `prueba_descom_difesi`, con un usuario con ese mismo nombre que tenga permisos y password `Descom@123`. El cotejamiento ideal de la BD sería `utf8mb4_unicode_ci`.
- Ejecutar `php artisan migrate`desde la raíz del proyecto para generar las tablas necesarias en la BD.
- Finalmente ejecutar `php artisan serve` desde la raíz del proyecto para desplegar la aplicación en [localhost:8000](http://localhost:8000)