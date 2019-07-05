<?php
//Variables que fueron pasadas por index.html
$nom = $_POST["Nombre"];
$ApellidoP = $_POST["ApellidoPaterno"];
$ApellidoM = $_POST["ApellidoMaterno"];

//cambiar a cualquier otro valor para trabajar en otra maquina

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

// Crea la conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisa la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "DELETE FROM autores_aux 
WHERE nombre = '$nom' 
AND apellido_paterno = '$ApellidoP' 
AND apellido_materno = '$ApellidoM'";

if ($conn->query($sql) === TRUE) {
    echo "$nom $ApellidoP $ApellidoM fue borrado de manera exitosa.";
    // Despues de mostrar el mensaje de borrado exitoso dormimos 3 segundos y regresamos a la pagina principal
    sleep(300);
    header('Location: index.html');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    sleep(2);
    header('Location: index.html');
}

$conn->close();

?>