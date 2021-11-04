<?php
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$tpmensaje = $_POST['tpmensaje'];
$mensaje = $_POST['mensaje'];

if (!empty($nombre) || !empty($telefono) || !empty($correo) || !empty($tpmensaje) || !empty($mensaje)) {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "contactame";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if (mysqli_connect_error()) {
        die('connect error(' . mysqli_connect_errno() . ')' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT telefono from usuario where telefono = ? limit 1";
        $INSERT = "INSERT INTO usuario (nombre, telefono, correo, tpmensaje, mensaje)values(?,?,?,?,?)";

        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("i", $telefono);
        $stmt->execute();
        $stmt->bind_result($telefono);
        $stmt->store_result();
        $rnum = $stmt->num_rows();
        if ($rnum == 0) {
            $stmt->close();
            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("sisss", $nombre, $telefono, $correo, $tpmensaje, $mensaje);
            $stmt->execute();
            echo "Hemos recolectado tu mensaje";
        } else {
            echo "Alguien ya ha registrado ese numero.";
        }
        $stmt->close();
        $conn->close();
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de contacto</title>
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <script src="js/jquery-3.6.0.js"></script>
    <script src="js/script.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>

    <section class="form_wrap">
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill" />
            </svg>
            <div>
                <h3 class="text-center">Hemos recibido tu comentario</h3>
                <p class="text-center">Espera tu respuesta.</p>
            </div>
        </div>

        <a href="index.html">Enviar nuevo mensaje</a>


    </section>

</body>

</html>