<?php
//Variables que fueron pasadas por index.html
$nom = $_POST["Nombre"];
$ApellidoP = $_POST["ApellidoPaterno"];
$ApellidoM = $_POST["ApellidoMaterno"];

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

$message = "";

// Crea la conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// IMPORTANTE, los acentos no funcionan sin esto
$acentos = $conn->query("SET NAMES 'utf8'");

// Revisa la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

// verifica si hay otro autor en la base con el mismo nombre y apellidos y los cuenta
$duplicado = "SELECT COUNT(nombre) AS num FROM autores_aux
WHERE nombre = '$nom' 
AND  apellido_paterno = '$ApellidoP' 
AND apellido_materno = '$ApellidoM'";

$query = mysqli_query($conn, $duplicado);

$row = mysqli_fetch_array($query);

$esta_repetido = ((int)$row['num'] == 0) ? FALSE : TRUE; 
 
if($esta_repetido) {
    $message = "El autor ".$nom." ".$ApellidoP." ".$ApellidoM." YA está en la base de datos";
}

else {    
    $sql = "INSERT INTO autores_aux (nombre, apellido_paterno, apellido_materno)
    VALUES ('$nom', '$ApellidoP', '$ApellidoM')";

    if ($conn->query($sql) === TRUE) {
        $message = $message."<br>$nom $ApellidoP $ApellidoM fue agregado a la base de manera exitosa.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>

<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos: Modificar base de datos</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    </head>
<body>
    <h1>Agregar Autor</h1>
    <?php
    echo "<h2>$message</h2>";
    ?>
</body>
</html>