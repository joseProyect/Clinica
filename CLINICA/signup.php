<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "prueba1";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No hay conexión: " . mysqli_connect_error());
}

if (isset($_POST["nombre"]) && isset($_POST["telefono"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $pass = $_POST["password"];

    // Prevenir SQL injection utilizando mysqli_real_escape_string
    $nombre = mysqli_real_escape_string($conn, $nombre);
    $telefono = mysqli_real_escape_string($conn, $telefono);
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Validar si el correo ya existe
    $check_query = "SELECT * FROM cliente WHERE email = '$email'";
    $result = mysqli_query($conn, $check_query);
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        header("Location: logo.html?error=El correo electrónico ya está registrado"); // Redirige a logo.html y muestra el mensaje de error
        exit();
    } else {
        // Insertar nuevo usuario si el correo no está registrado
        $query = "INSERT INTO cliente (nombre, telefono, email, password) VALUES ('$nombre', '$telefono', '$email', '$pass')";
        if (mysqli_query($conn, $query)) {
            header("Location: logo.html?success=Registro exitoso"); // Redirige a logo.html y muestra el mensaje de éxito
            exit();
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($conn);
        }
    }
} else {
    header("Location: logo.html?error=No se recibieron los datos necesarios para registrarse"); // Redirige a logo.html y muestra el mensaje de error
    exit();
}

mysqli_close($conn);
?>
