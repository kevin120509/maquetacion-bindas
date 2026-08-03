<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    header("Allow: POST");
    exit("Método no permitido");
}

$destino = "kevin.36137@gmail.com";
$asunto = "Contacto desde el sitio web";

$nombre = trim($_POST["nombre"] ?? "");
$apellido = trim($_POST["apellido"] ?? "");
$email = trim($_POST["email"] ?? "");
$comentarios = trim($_POST["comentarios"] ?? "");

if ($nombre === "" || $apellido === "" || $comentarios === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    exit("Completa todos los campos con datos válidos");
}

$nombreSeguro = htmlspecialchars($nombre, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
$apellidoSeguro = htmlspecialchars($apellido, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
$emailSeguro = htmlspecialchars($email, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
$comentariosSeguro = nl2br(htmlspecialchars($comentarios, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8"));

$contenido = "<b>Nombre:</b> {$nombreSeguro}<br>"
    . "<b>Apellido:</b> {$apellidoSeguro}<br>"
    . "<b>Email:</b> {$emailSeguro}<br>"
    . "<b>Comentarios:</b><br>{$comentariosSeguro}";

$encabezados = "MIME-Version: 1.0\r\n";
$encabezados .= "Content-Type: text/html; charset=UTF-8\r\n";
$encabezados .= "From: Sitio web <no-reply@localhost>\r\n";
$encabezados .= "Reply-To: {$email}\r\n";

if (!mail($destino, $asunto, $contenido, $encabezados)) {
    http_response_code(500);
    exit("Error al enviar el mensaje");
}

header("Location: gracias.html", true, 303);
exit;
