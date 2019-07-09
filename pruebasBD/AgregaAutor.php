<?php
//Variables que fueron pasadas por index.html
$nom = $_POST["Nombre"];
$ApellidoP = $_POST["ApellidoPaterno"];
$ApellidoM = $_POST["ApellidoMaterno"];

// Cambiar a cualquier otro valor para trabajar en otra maquina
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

$message = "";

// Crea la conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Revisa la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// <<<<<<<<<< Modificar >>>>>>>>>>>

$duplicado = "SELECT COUNT(nombre) AS num FROM autores_aux
WHERE nombre = '$nom' AND  apellido_paterno = '$ApellidoP' AND apellido_materno = '$ApellidoM'";

$query = mysqli_query($conn, $duplicado);

$row = mysqli_fetch_array($query);


if((int) $row['num'] > 0) {
    $message = "El autor YA está en la base de datos";
}

else if((int) $row['num'] == 0) {
    $message = "El autor NO está en la base de datos";
    
    $sql = "INSERT INTO autores_aux (nombre, apellido_paterno, apellido_materno)
    VALUES ('$nom', '$ApellidoP', '$ApellidoM')";

    if ($conn->query($sql) === TRUE) {
        $message = $message."<br>$nom $ApellidoP $ApellidoM fue agregado a la base de manera exitosa";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

}

$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Hola</title>
</head>
<body>
    <h1>Hola!</h1>
    <?php echo "<h2>$message</h2>"; ?>
</body>
</html>