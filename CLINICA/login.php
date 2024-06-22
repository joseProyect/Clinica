<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "prueba1";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("No hay conexión: " . mysqli_connect_error());
}

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $email = $_POST["email"];
    $pass = $_POST["password"];

    // Prevenir SQL injection utilizando mysqli_real_escape_string
    $email = mysqli_real_escape_string($conn, $email);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Consulta SQL para verificar las credenciales
    $query = "SELECT * FROM cliente WHERE email = '$email' AND password = '$pass'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Error en la consulta: " . mysqli_error($conn));
    }
    
    $nr = mysqli_num_rows($result);

    if ($nr == 1) {
        header("Location: index.html"); // Redirige a la página principal si las credenciales son correctas
        exit();
    } else {
        header("Location: logo.html?error=Correo o contraseña incorrectos"); // Redirige a logo.html y muestra el mensaje de error
        exit();
    }
} else {
    header("Location: logo.html?error=No se recibieron los datos necesarios para iniciar sesión"); // Redirige a logo.html y muestra el mensaje de error
    exit();
}

mysqli_close($conn);
?>
