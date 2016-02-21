<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Censo de las primarias de Alternativa Universitaria</title>
    <meta name="description" content="Aplicación de inscripción al censo para participar en las primarias de Alternativa Universitaria" />
    <link rel="icon" href="icon.png">
    <link href="styles.css" rel="stylesheet">
    <script async src="script.js"></script>
</head>

<body>
  <header>
    <h1>Participa en las primarias de Alternativa Universitaria</h1>
  </header>

  <article>
<?php
  if ($_POST['nombre']) {
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $tlf = $_POST['telefono'];
    $dni = $_POST['dni'];
    $email = $_POST['email'];
    $campus = $_POST['campus'];
    $centro = $_POST['centro'];
    $acr = $_FILES['acr']['name'];
    $lopd = $_POST['lopd'];
    $date = time();


// Envío a la base de datos y feedback al usuario

?>
  <p>¡Gracias por participar, <?php echo $nombre ?>! En breve recibirás un correo verificando que hemos recibido tus datos correctamente. Revisa tu bandeja de spam. Te iremos informando a través de la dirección de correo que nos has facilitado de todo el proceso de primarias.</p>
  <dl>
    <dt>Nombre</dt>
    <dd><?php echo $nombre ?></dd>
    <dt>Apellido 1</dt>
    <dd><?php echo $apellido1 ?></dd>
    <dt>Apellido 2</dt>
    <dd><?php echo $apellido2 ?></dd>
    <dt>Teléfono</dt>
    <dd><?php echo $tlf ?></dd>
    <dt>DNI</dt>
    <dd><?php echo $dni ?></dd>
    <dt>Email</dt>
    <dd><?php echo $email ?></dd>
    <dt>Campus</dt>
    <dd><?php echo $campus ?></dd>
    <dt>Centro</dt>
    <dd><?php echo $centro ?></dd>
    <dt>Acreditación</dt>
    <dd><?php echo $acr ?></dd>
    <dt>Aceptación</dt>
    <dd><?php echo $lopd ?></dd>
    <dt>Fecha</dt>
    <dd><?php echo $date ?></dd>
  </dl>
<?php


  /* CÓDIGO PARA ENVÍO DE CORREO
    $from = '';
    $to = '';
    $subject = '';
    $headers = 'From: '. $from . "\r\n" . 'Reply-To: '. $email . "\r\n" . 'Content-Type: text/plain; charset=UTF-8' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

    $body = "Remitente: $nombre\nTeléfono: $tlf\nE-Mail: $email\nEmpresa: $emp\nDirección: $dir\nLocalidad: $loc\nProvincia: $prov\nAsunto: $asunto\nMensaje:\n$msg";

  if ($nombre != '' && $tlf != '' && $email != '' && $asunto != '' && $msg != '') {
    $mail =  mail($to, $subject, $body, $headers, '-fwebmaster@example.com');
    if ($mail){
      echo '<p>Gracias por ponerse en contacto con nosotros.<br>En el plazo más breve posible nos pondremos en contacto con usted.</p>';
    } else {
      echo '<p>Algo no ha ido bien. Por favor, vuélvalo a intentar.</p>';
    }
  } else {
    echo '<p>Por favor, rellene todos los campos obligatorios.</p>';
  }
*/

} else { ?>
  	<h2>Instrucciones</h2>
  	<p>Para inscribirte en el censo y poder participar en las votaciones que se realicen desde Alternativa Universitaria tan solo debes rellenar el siguiente formulario. Envíanos cualquier duda, problema o sugerencia a <a href="mailto:au@uva.es" target="_blank">au@uva.es</a>.</p>

  	<form action="index.php" enctype="multipart/form-data" method="post" name="form">
      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" size="20" placeholder="Introduce tu nombre" required />

      <label for="apellido1">Primer apellido</label>
      <input type="text" id="apellido1" name="apellido1" size="20" placeholder="Introduce tu primer apellido" required />

      <label for="apellido2">Segundo apellido</label>
      <input type="text" id="apellido2" name="apellido2" size="20" placeholder="Introduce tu segundo apellido" />

      <label for="dni">DNI</label>
  		<input type="text" id="dni" name="dni" size="20" placeholder="Introduce tu DNI. Ej.: 12345678K." required />

      <label for="email">Correo electrónico</label>
  		<input type="email" id="email" name="email" size="20" placeholder="Introduce tu correo electrónico. Ej.: 12345678K." required />

  		<label for="telefono">Teléfono</label>
      <input type="text" id="telefono" name="telefono" size="9" palceholder="Introduce tu número de teléfono" />

  		<label for="campus">Campus</label>
      <select id="campus" name="campus" required data-campus>
        <option></option>
        <option value="047">Valladolid</option>
        <option value="034">Palencia</option>
        <option value="040">Segovia</option>
        <option value="042">Soria</option>
      </select>

      <label for="centro">Centro (Escuela o Facultad)</label>
      <select id="centro" name="centro" required>
        <option></option>
        <option value="1" data-center="034">Escuela de Enfermería</option>
        <option value="2" data-center="034">Escuela Técnica Superior de Ingenierías Agrarias</option>
        <option value="3" data-center="034">Facultad de Ciencias del Trabajo</option>
        <option value="4" data-center="034">Facultad de Educación</option>

        <option value="5" data-center="040">Escuela de Ingeniería Informática</option>
        <option value="6" data-center="040">Facultad de Ciencias Sociales, Jurídicas y de la Comunicación</option>
        <option value="7" data-center="040">Facultad de Educación</option>

        <option value="8" data-center="042">Facultad de Educación</option>
        <option value="9" data-center="042">Escuela Universitaria de Ingenierías Agrarias</option>
        <option value="10" data-center="042">Facultad de Fisioterapia</option>
        <option value="11" data-center="042">Facultad de Traducción e Interpretación</option>
        <option value="12" data-center="042">Facultad de Ciencias Empresariales y del Trabajo</option>
        <option value="13" data-center="042">Facultad de Enfermería</option>

        <option value="14" data-center="047">Facultad de Ciencias</option>
        <option value="15" data-center="047">Facultad de Ciencias Económicas y Empresariales</option>
        <option value="16" data-center="047">Facultad de Comercio</option>
        <option value="17" data-center="047">Facultad de Derecho</option>
        <option value="18" data-center="047">Facultad de Educación y Trabajo Social</option>
        <option value="19" data-center="047">Facultad de Enfermería</option>
        <option value="20" data-center="047">Facultad de Filosofía y Letras</option>
        <option value="21" data-center="047">Facultad de Medicina</option>
        <option value="22" data-center="047">ETS de Arquitectura</option>
        <option value="23" data-center="047">Escuela de Ingenieras Industriales</option>
        <option value="24" data-center="047">Escuela de Ingeniería Informática</option>
        <option value="25" data-center="047">Escuela Técnica Superior de Ingenieros de Telecomunicación</option>
      </select>

      <label for="acr">Acreditación 1</label>
      <input type="hidden" name="MAX_FILE_SIZE" value="10000" />
      <input type="file" id="acr" name="acr" multiple required/>
      <p>Sube uno o varios archivos de tamaño inferior a 10MB para poder certificar que perteneces a la UVa. Por ejemplo, saca una foto de tu Tarjeta Inteligente de la UVa o de tu matrícula de este curso.</p>

      <p>Al enviar este formulario autorizas a incorporar tus datos a un fichero de "Alternativa Universitaria". Tus datos se usarán exclusivamente para la confección del censo electoral de la plataforma y proporcionarte información sobre la misma y no se venderán ni compartirán con ninguna otra entidad. Tienes derecho a acceder, rectificar, cancelar y oponerte en los términos y plazos establecidos por la legislación a través de <a href="mailto:au@uva.es" target="_blank">au@uva.es</a>.</p>
      <label>
        <input name="lopd" type="checkbox" required/>
        Acepto la cláusula de protección de datos
      </label>

      <input type="submit" name="submit" value="Enviar" />
  	</form>
<?php } ?>
  </article>
  <footer>
    <h2>Pie de página</h2>
    <p>Texto auxiliar para pie de página.</p>
  </footer>
</html>
