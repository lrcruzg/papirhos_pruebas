<?php
$Nombre = $ApellidoP = $ApellidoM = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Nombre = test_input($_POST["Nombre"]);
    $ApellidoP = test_input($_POST["ApellidoPaterno"]);
    $ApellidoM = test_input($_POST["ApellidoMaterno"]);
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// crea la conexión a la db
require_once("db_connect.php");

// IMPORTANTE, los acentos no funcionan sin esto
$acentos = $conn->query("SET NAMES 'utf8'");

// verifica si existe en la base el autor a borrar
$existe = "SELECT COUNT(nombre) AS num FROM autores_aux
WHERE nombre = '$Nombre' 
AND  apellido_paterno = '$ApellidoP' 
AND apellido_materno = '$ApellidoM'";

$query = mysqli_query($conn, $existe);

$row = mysqli_fetch_array($query);

$existe_autor = ((int)$row['num'] == 0) ? FALSE : TRUE;

if(!$existe_autor) {
	$message = "$Nombre $ApellidoP $ApellidoM no existe en la base.";
}

if($existe_autor) {
	$sql = "DELETE FROM autores_aux 
	WHERE nombre = '$Nombre'
	AND apellido_paterno = '$ApellidoP' 
	AND apellido_materno = '$ApellidoM'";

	if ($conn->query($sql) === TRUE) {
	    $message = "$Nombre $ApellidoP $ApellidoM fue borrado de manera exitosa.";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
}

$conn->close();

?>

<html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos - Modificar base de datos</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    </head>
<body>
    <h1>Eliminar Autor</h1>
    <nav>
        <a href="/PruebasBD/index.html">Inicio</a> |
        <a href="/PruebasBD/MuestraAutores.php">Autores</a> |
        <a href="/PruebasBD/MuestraLibros.php">Libros</a> |
    </nav>

    <?php
    echo "<h2>$message</h2>";
    ?>
</body>
</html>