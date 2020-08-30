var pruebaDescom = {

    carpetaApp: '', /* En caso de no desplegar en el raíz, configurar el nombre de la carpeta de la aplicación */
    recorte: null,
    windowURL: null,
    minPixelsImagen: 600,
    pixelsRecorte: 300,

    getBaseUrl: function(controlador) {

        var url = window.location;
        var controlador = controlador || '';

        return (url.protocol + '//' + url.host + (this.carpetaApp.length ? '/' + this.carpetaApp : '') + 
            (controlador.length ? '/' + controlador : ''));
    },

    generarImagenRecortada: function() {

        var imagen = $('#imagen');

        if (pruebaDescom.recorte != null) {
            imagen.cropper('destroy');
        }

        imagen.cropper({
            autoCrop: true,
            autoCropArea: 1,
            aspectRatio: 1,
            viewMode: 2
        });

        pruebaDescom.recorte = imagen.data('cropper');
    },

    enCargaFicheroImagen: function(event) {

        var windowURL = pruebaDescom.windowURL;
        var minPixelsImagen = pruebaDescom.minPixelsImagen;

        var ficheroInput = $('#fichero-subida');
        var imagen = $('#imagen');
        var fichero = event.target.files[0];

        var imagenObj = new Image();
        var imagenSrc = null;

        if (windowURL) {
            imagenObj.onload = function() {
                let imagenWidth = this.width;
                let imagenHeight = this.height;
    
                if (imagenWidth < minPixelsImagen || imagenHeight < minPixelsImagen) {
                    alert('El tamaño de la imagen no debe ser inferior a ' + minPixelsImagen + 'x' + minPixelsImagen + ' pixels.');
                } else {
                    $('#imagen-data').empty();
                    ficheroInput.siblings('.custom-file-label').addClass('selected').html(fichero.name);
                    imagen.attr('src', imagenSrc);
                    pruebaDescom.generarImagenRecortada();
                }
            };

            imagenObj.onerror = function() {
                alert('No es válido el fichero de tipo ' + fichero.type);
            };

            imagenSrc = windowURL.createObjectURL(fichero);
            imagenObj.src = imagenSrc;
        }
    },

    mostrarOcultarPassword: function(event) {

        var groupId = $(this).parents('.input-group').attr('id');
        var groupInputType = $('#' + groupId + ' input').attr('type');
        var mostrar = (groupInputType == 'password');

        event.preventDefault();

        $('#' + groupId + ' input').attr('type', (mostrar ? 'text' : 'password'));
        $('#' + groupId + ' i').removeClass(mostrar ? 'fa-eye' : 'fa-eye-slash');
        $('#' + groupId + ' i').addClass(mostrar ? 'fa-eye-slash' : 'fa-eye');
    },

    enClickEnvioForm: function(event) {

        if (pruebaDescom.recorte != null) {
            let pixelsRecorte = pruebaDescom.pixelsRecorte;
            let canvas = pruebaDescom.recorte.getCroppedCanvas({ width: pixelsRecorte, height: pixelsRecorte });
            let imagenDataUrl = canvas.toDataURL('image/jpeg', 1.0);
            $('#imagen-data').val(imagenDataUrl);
        }

        $('form').submit();
    }    
};

$(document).ready(function() {

    pruebaDescom.windowURL = window.URL || window.webkitURL;

    if ($('.mostrar-ocultar-password').length) {
        $('.mostrar-ocultar-password a').click(pruebaDescom.mostrarOcultarPassword);
    }

    if ($('#fichero-subida').length) {
        $('#fichero-subida').change(pruebaDescom.enCargaFicheroImagen);
    }

    if ($('#btn-registro').length) {
        $('#btn-registro').click(pruebaDescom.enClickEnvioForm);
    }
});