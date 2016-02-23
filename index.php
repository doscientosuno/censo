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
  <header class="container">
    <h1>Elecciones al Claustro<br />Participa en las primarias de<br />Alternativa Universitaria</h1>
    <hr />
  </header>

  <article class="container">
<?php
  if($_POST['dni']){
    $msg = '';
    $error = 0;

    $servername = "localhost";
    $db = "altuni";
    $username = "altuni";
    $password = "ojete";

    // Comprobamos los campos obligatorios
    if ($_POST['nombre'] && $_POST['dni'] && $_POST['dnil'] && $_POST['pw'] && $_POST['apellido1'] && $_POST['email'] && $_POST['cuerpo'] && $_POST['lopd'] && $_FILES['acr']['name']) {
      $dni = $_POST['dni'].strtoupper($_POST['dnil']);
      $pw = md5($_POST['pw']);
      $nombre = $_POST['nombre'];
      $apellido1 = $_POST['apellido1'];
      $apellido2 = $_POST['apellido2'];
      $tlf = $_POST['telefono'];
      $email = $_POST['email'];
      $cuerpo = $_POST['cuerpo'];
      $campus = $_POST['campus'];
      $centro = $_POST['centro'];
      $lopd = $_POST['lopd'] === 'on' ? 1 : 0;
      $prim = $_POST['prim'] === 'on' ? 1 : 0;
      $bol = $_POST['bol'] === 'on' ? 1 : 0;

      // Gestión del fichero enviado
      if($_FILES['acr']['name']) {
      	if(!$_FILES['acr']['error']) {
      		$new_file_name = strtolower($_FILES['acr']['tmp_name']);
      		if($_FILES['acr']['size'] > (3 * 1024 * 1024)) {
      			$error = 1;
      			$msg = "<p>El fichero de tu acreditación es demasiado grande</p>";
      		} else {
            $file = addslashes(file_get_contents($_FILES['acr']['tmp_name']));
          }
      	}
      }

      // Comprobación del DNI
      preg_match('/^[XYZ]?([0-9]{7,8})([A-Z])$/i', $dni, $matches);
      list(, $number, $letter) = $matches;
      $map = 'TRWAGMYFPDXBNJZSQVHLCKE';
      if (strtoupper($letter) !== $map[((int) $number) % 23]) {
        $error = 1;
        $msg .= "<p>El DNI no es válido.</p>";
      }

    } else {
      $error = 1;
      $msg .= "<p>No has cumplimentado todos los datos.</p>";
    }

    // Envío a la base de datos y feedback al usuario
    if ($error === 0) {
      // Create connection
      $conn = new mysqli($servername, $username, $password, $db);
      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      $conn->set_charset("utf8");
      // Crear tabla si no existe
      $query = "CREATE TABLE IF NOT EXISTS `altuni`.`users` (
        `id` varchar(9) NOT NULL,
        `pw` varchar(255) NOT NULL,
        `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `nombre` varchar(60) NOT NULL,
        `apellido1` varchar(60) NOT NULL,
        `apellido2` varchar(60) DEFAULT NULL,
        `telefono` varchar(9) DEFAULT NULL,
        `email` varchar(60) NOT NULL,
        `cuerpo` varchar(10) NOT NULL,
        `campus` varchar(10) DEFAULT NULL,
        `centro` varchar(10) DEFAULT NULL,
        `acreditacion` longblob NOT NULL,
        `lopd` tinyint(1) NOT NULL,
        `primarias` tinyint(1) DEFAULT NULL,
        `boletin` tinyint(1) DEFAULT NULL,
        `validado` tinyint(1) DEFAULT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `id` (`id`)
      ) ENGINE=MyISAM DEFAULT CHARSET=utf8";

      if ($conn->query($query) !== TRUE) {
        $error = 1;
        $msg .= "<p>Ha habido un problema al crear la tabla.</p>";
      }

      $query = "INSERT INTO `users` (`id`, `pw`, `fecha`, `nombre`, `apellido1`, `apellido2`, `telefono`, `email`, `cuerpo`, `campus`, `centro`, `acreditacion`, `lopd`, `primarias`, `boletin`, `validado`) VALUES ('$dni', '$pw', CURRENT_TIMESTAMP, '$nombre', '$apellido1', '$apellido2', '$tlf', '$email', '$cuerpo', '$campus', '$centro', '{$file}', '$lopd', '$prim', '$bol', '0')";

      if ($conn->query($query) !== TRUE) {
        $error = 1;
        echo "Error: " . $sql . "<br>" . $conn->error;
        $msg .= "<p>Ha habido un problema con la base de datos.</p>";
      }

      $conn->close();
    }
    // Envío de correo
    if ($error === 0) {
      $from = 'au@uva.es';
      $to = $email;
      $subject = 'Inscripción en el censo de primarias de Alternativa Universitaria';
      $headers = 'From: '. $from . "\r\n" . 'Reply-To: '. $from . "\r\n" . 'Content-Type: text/plain; charset=UTF-8' . "\r\n" . 'X-Mailer: PHP/' . phpversion();

      $body = "Hola, $nombre,\r\nTe confirmamos que has sido registrado correctamente en la base de datos del censo electoral para participar en nuestras primarias. Tu usuario es $dni y la contraseña la que indicaste.\r\n¡Gracias por participar!\r\nAlternativa Universitaria";

      $mail = mail($to, $subject, $body, $headers, '-fwebmaster@example.com');
      if (!$mail) {
        $error = 1;
        $msg .= "<p>No se pudo enviar el correo electrónico.</p>";
      }
    }
    if ($error === 0) {
?>
    <p>¡Gracias por participar, <?php echo $nombre ?>! En breve recibirás un correo verificando que hemos recibido tus datos correctamente. Revisa tu bandeja de spam. Te iremos informando a través de la dirección de correo que nos has facilitado de todo el proceso de primarias.</p>

<?php
    } else {
      echo $msg;
    }
  } else {
?>

  	<h2>Instrucciones</h2>
  	<p>Para inscribirte en el censo y poder participar en las votaciones que se realicen desde Alternativa Universitaria tan solo debes rellenar el siguiente formulario. Envíanos cualquier duda, problema o sugerencia a <a href="mailto:au@uva.es" target="_blank">au@uva.es</a>.</p>

  	<form action="index.php" enctype="multipart/form-data" method="post" name="form">
      <div class="form-group">
        <label class="control-label" for="dni">DNI</label>
        <div class="form-control">
    		    <input type="text" id="dni" name="dni" maxlength="8" size="15" placeholder="DNI" required pattern="[XYZ]?([0-9]{7,8})"/>-<input type="text" id="dnil" name="dnil" maxlength="1" size="3" required pattern="[A-Za-z]{1}"/>
          </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="pw">Contraseña</label>
        <div class="form-control">
      		<input type="password" id="pw" name="pw" maxlength="20" size="20" placeholder="Contraseña" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?=.*[A-Z])(?=.*[a-z]).*$" required />
          <p><small>Debe contener al menos 8 caracteres, entre los cuales debe haber al menos una mayúscula, una minúscula y un número.</small></p>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="pw2">Contraseña (de nuevo)</label>
        <div class="form-control">
  		    <input type="password" id="pw2" name="pw2" maxlength="20" size="20" placeholder="Repite tu contraseña" required />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="nombre">Nombre</label>
        <div class="form-control">
          <input type="text" id="nombre" name="nombre" maxlength="60" size="20" placeholder="Tu nombre" required />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="apellido1">Primer apellido</label>
        <div class="form-control">
          <input type="text" id="apellido1" name="apellido1" maxlength="60" size="20" placeholder="Tu primer apellido" required />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="apellido2">Segundo apellido</label>
        <div class="form-control">
          <input type="text" id="apellido2" name="apellido2" maxlength="60" size="20" placeholder="Tu segundo apellido" />
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="email">Correo electrónico</label>
        <div class="form-control">
  		    <input type="email" id="email" name="email" maxlength="60" size="20" placeholder="Tu correo electrónico." required />
        </div>
      </div>
      <div class="form-group">
    		<label class="control-label" for="telefono">Teléfono</label>
        <div class="form-control">
          <input type="text" id="telefono" name="telefono" maxlength="9" size="20" placeholder="Tu número de teléfono" pattern="[679][0-9]{8}"/>
        </div>
      </div>
      <div class="form-group">
    		<label class="control-label" for="cuerpo">Cuerpo</label>
        <div class="form-control">
          <select id="cuerpo" name="cuerpo" required data-body>
            <option></option>
            <option value="12">Estudiantes de Grado y Máster</option>
            <option value="3">Estudiantes de Tercer Ciclo</option>
          </select>
        </div>
      </div>
      <div class="form-group" data-campus>
    		<label class="control-label" for="campus">Campus</label>
        <div class="form-control">
          <select id="campus" name="campus" required data-campus-value>
            <option></option>
            <option value="047">Valladolid</option>
            <option value="034">Palencia</option>
            <option value="040">Segovia</option>
            <option value="042">Soria</option>
          </select>
        </div>
      </div>
      <div class="form-group" data-center>
        <label class="control-label" for="centro">Centro (Escuela o Facultad)</label>
        <div class="form-control">
          <select id="centro" name="centro" required>
            <option></option>
            <option value="1" data-campus-center="034">Escuela de Enfermería</option>
            <option value="2" data-campus-center="034">Escuela Técnica Superior de Ingenierías Agrarias</option>
            <option value="3" data-campus-center="034">Facultad de Ciencias del Trabajo</option>
            <option value="4" data-campus-center="034">Facultad de Educación</option>

            <option value="5" data-campus-center="040">Escuela de Ingeniería Informática</option>
            <option value="6" data-campus-center="040">Facultad de Ciencias Sociales, Jurídicas y de la Comunicación</option>
            <option value="7" data-campus-center="040">Facultad de Educación</option>

            <option value="8" data-campus-center="042">Facultad de Educación</option>
            <option value="9" data-campus-center="042">Escuela Universitaria de Ingenierías Agrarias</option>
            <option value="10" data-campus-center="042">Facultad de Fisioterapia</option>
            <option value="11" data-campus-center="042">Facultad de Traducción e Interpretación</option>
            <option value="12" data-campus-center="042">Facultad de Ciencias Empresariales y del Trabajo</option>
            <option value="13" data-campus-center="042">Facultad de Enfermería</option>

            <option value="14" data-campus-center="047">Facultad de Ciencias</option>
            <option value="15" data-campus-center="047">Facultad de Ciencias Económicas y Empresariales</option>
            <option value="16" data-campus-center="047">Facultad de Comercio</option>
            <option value="17" data-campus-center="047">Facultad de Derecho</option>
            <option value="18" data-campus-center="047">Facultad de Educación y Trabajo Social</option>
            <option value="19" data-campus-center="047">Facultad de Enfermería</option>
            <option value="20" data-campus-center="047">Facultad de Filosofía y Letras</option>
            <option value="21" data-campus-center="047">Facultad de Medicina</option>
            <option value="22" data-campus-center="047">ETS de Arquitectura</option>
            <option value="23" data-campus-center="047">Escuela de Ingenieras Industriales</option>
            <option value="24" data-campus-center="047">Escuela de Ingeniería Informática</option>
            <option value="25" data-campus-center="047">Escuela Técnica Superior de Ingenieros de Telecomunicación</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label class="control-label" for="acr">Acreditación</label>
        <div class="form-control">
          <input type="hidden" name="MAX_FILE_maxlength" value="10000" />
          <input type="file" id="acr" name="acr" required data-upload/>
          <p><small>Sube un archivo de tamaño inferior a 3MB para poder certificar que perteneces a la UVa. Por ejemplo, saca una foto de tu Tarjeta Inteligente de la UVa o de tu matrícula de este curso.</small></p>
        </div>
      </div>
      <p>Al enviar este formulario autorizas a incorporar tus datos a un fichero de "Alternativa Universitaria". Tus datos se usarán exclusivamente para la confección del censo electoral de la plataforma y proporcionarte información sobre la misma y no se venderán ni compartirán con ninguna otra entidad. Tienes derecho a acceder, rectificar, cancelar y oponerte en los términos y plazos establecidos por la legislación a través de <a href="mailto:au@uva.es" target="_blank">au@uva.es</a>.</p>

      <div class="form-group">
        <label>
          <input name="lopd" type="checkbox" required/>
          Acepto la cláusula de protección de datos
        </label>
      </div>
      <div class="form-group">
        <label>
          <input name="prim" type="checkbox" />
          Quiero recibir información sobre las elecciones de estudiantes al Claustro Universitario 2016.
        </label>
      </div>
      <div class="form-group">
        <label>
          <input name="bol" type="checkbox" />
          Quiero suscribirme al boletín electrónico de Alternativa Universitaria.
        </label>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="Enviar" />
      </div>
  	</form>
<?php } ?>
  </article>
</html>
