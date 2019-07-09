<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <title>Papirhos - Agregar Libro</title>
    <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
</head>
<body>
    <h1>Agrega Libro</h1>
    <?php 
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

    ?>
</body>
</html>