<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos - Ventas alternativa</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    </head>
    <body>
    <h1>Ventas</h1>

    <form action="VarVentas.php" method="POST">
      <fieldset>
        <legend>Elige el libro</legend>
        <b>Colección:</b>
        <input type="radio" name="col" value="Papir" checked> Papirhos
        <input type="radio" name="col" value="Txt"> Textos
        <input type="radio" name="col" value="Olimp"> Olimpiadas
        <input type="radio" name="col" value=""> Otro
        <br>
        <input type="submit" value="Submit" />
      </fieldset>
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pruebasBD";

    if($_POST) {
    // Crea la conexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Revisa la conexion
    if ($conn->connect_error) {
        die("Conexion fallida: " . $conn->connect_error);
    }

    /*
    $sql = "SELECT titulo, precio_descuento FROM libros_aux
    JOIN precios_libro
        ON precios_libro.id_libros = libros_aux.id_libros
    WHERE titulo LIKE '%$busqueda%' ORDER BY titulo ASC";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    */

    }
    ?>

    <form action="VarVentas.php">
        <select name="cars">
            <option value="volvo">Volvo</option>
        </select>
        <input type="submit" value="Submit" />
    </form>

    <script src="" async defer></script>
    </body>
</html>