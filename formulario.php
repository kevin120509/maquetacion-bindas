<?php

$destino = "kevin.36137@gmail.com";
$asunto = "Contacto desde el sitio web";

$nombre = htmlspecialchars($_POST["nombre"] ?? '');
$apellido = htmlspecialchars($_POST["apellido"] ?? '');
$email = htmlspecialchars($_POST["email"] ?? '');
$comentarios = htmlspecialchars($_POST["comentarios"] ?? '');

$contenido = "<b>Nombre :</b> $nombre<br><b>Apellido :</b> $apellido<br><b>Email :</b> $email<br><b>Comentarios : </b> $comentarios";

// PARA QUE RECONOZCA LAS ETIQUETAS HTML

$encabezados  = "MIME-Version: 1.0" . "\r\n";
$encabezados .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$encabezados .= "From: $nombre $apellido <$email>" . "\r\n";

// FUNCION MAIL Y REDIRECCIONAMIENTO
if (mail($destino, $asunto, $contenido, $encabezados)) {
    header("Location: gracias.html");
    exit;
} else {
    echo "Error al enviar el mensaje";
}

