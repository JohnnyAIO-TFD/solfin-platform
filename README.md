# solfin-platform
# Plataforma de archivos, donde se sube en un lugar aparte y se reflejara en Wordpress

1) Crear una bases de datos en phpmyadmin

2) Luego se importara en la carpeta _db crud.sql y crud_2.sql

3) La carpeta de solfin-platform lo mueves a la carpeta principal

4) Ahora la carpeta de views-solfin eso se debe ir a la carpeta de wp-content/themes/theme-activado/

5) Lo importante editar el archivo function.php y agregar lo siguiente:

# En el directorio themes/your-themes/function.php

# Agregar el siguiente contenido:

add_shortcode('publicaciones', 'publicaciones');
function publicaciones() {
    include('views_solfin/publicaciones.php');
}

add_shortcode('cumplimiento', 'cumplimiento');
function cumplimiento() {
    include('views_solfin/cumplimiento.php');
}

add_shortcode('contadores', 'contadores');
function contadores() {
    include('views_solfin/contabilidad.php');
}

Finalmente importa tus trabajos con [contadores] en este caso visualiza la funcion que tienes.
