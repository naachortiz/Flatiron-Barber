<?php

if(!$_POST) exit;

// Verificación de dirección de correo electrónico, no editar.
function esCorreoElectronico($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$nombre     = $_POST['nombre'];
$apellido     = $_POST['apellido'];
$correo    = $_POST['correo'];
$telefono   = $_POST['telefono'];
$select_precio   = $_POST['select_precio'];
$select_servicio   = $_POST['select_servicio'];
$asunto  = $_POST['asunto'];
$comentarios = $_POST['comentarios'];
$verificacion   = $_POST['verificacion'];

if(trim($nombre) == '') {
	echo '<div class="error_message">¡Atención! Debes ingresar tu nombre.</div>';
	exit();
}  else if(trim($correo) == '') {
	echo '<div class="error_message">¡Atención! Por favor ingresa una dirección de correo electrónico válida.</div>';
	exit();
} else if(!esCorreoElectronico($correo)) {
	echo '<div class="error_message">¡Atención! Has ingresado una dirección de correo electrónico inválida, inténtalo de nuevo.</div>';
	exit();
}

if(trim($comentarios) == '') {
	echo '<div class="error_message">¡Atención! Por favor ingresa tu mensaje.</div>';
	exit();
}

if(get_magic_quotes_gpc()) {
	$comentarios = stripslashes($comentarios);
}

// Opción de configuración.
// Ingresa la dirección de correo electrónico a la que deseas que se envíen los correos electrónicos.
// Ejemplo $address = "joe.doe@yourdomain.com";

//$address = "example@themeforest.net";
$direccion_correo = "example@yourdomain.com";

// Opción de configuración.
// Es decir, el asunto estándar aparecerá como, "You've been contacted by John Doe."
// Ejemplo, $e_subject = '$nombre . ' te ha contactado a través de Tu Sitio Web.';

$e_subject = 'Te ha contactado ' . $nombre . '.';

// Opción de configuración.
// Puedes cambiar esto si sientes que es necesario.
// Desarrolladores, pueden desear agregar más campos al formulario, en cuyo caso debes asegurarte de agregarlos aquí.

$e_body = "Te ha contactado $nombre. $nombre ha seleccionado el servicio de $select_servicio, su mensaje adicional es el siguiente. El presupuesto máximo del cliente es $select_precio, para este proyecto." . PHP_EOL . PHP_EOL;
$e_content = "\"$comentarios\"" . PHP_EOL . PHP_EOL;
$e_reply = "Puedes contactar a $nombre por correo electrónico, $correo o por teléfono $telefono";

$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

$headers = "From: $correo" . PHP_EOL;
$headers .= "Reply-To: $correo" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($direccion_correo, $e_subject, $msg, $headers)) {

	// El correo electrónico se ha enviado correctamente, muestra una página de éxito.

	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1>Correo Electrónico Enviado Exitosamente.</h1>";
	echo "<p>Gracias <strong>$nombre</strong>, tu mensaje ha sido enviado a nosotros.</p>";
	echo "</div>";
	echo "</fieldset>";

} else {

	echo '¡ERROR!';

}
?>


