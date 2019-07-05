<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos - Ventas</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
        <style>
            input[type="text"] { width: 200%; }
            table#op {
              font-family: arial, sans-serif;
              border-collapse: collapse;
            }

            td#op, th#op {
              border: 1px solid #dddddd;
              padding: 3px;
            }

            tr:nth-child#op(even) {
              background-color: #dddddd;
            }
        </style>
    </head>
    <br>

  <body>
    <h1>Ventas</h1>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
        <table>
            <tr>
                <td align="right">Buscar libro: </td>
                <td><input type="text" name="tit" placeholder="Título, Autor"></td>
            </tr>
        </table>
        <input type="submit" value="Buscar">
    </form>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "pruebasbd";

    if($_POST) {

    $busqueda = $_POST["tit"];

    // Crea la conexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Revisa la conexion
    if ($conn->connect_error) {
        die("Conexion fallida: " . $conn->connect_error);
    }

    $sql = "SELECT titulo, precio_descuento FROM libros_aux
    JOIN precios_libro
        ON precios_libro.id_libros = libros_aux.id_libros
    WHERE titulo LIKE '%$busqueda%' ORDER BY titulo ASC";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    }   
    ?>
    <form>
    <table id="op">
        <caption class="title"><b>Resultados</caption>
        <thead>
            <tr>
                <th>Título</th>
                <th>Precio Descuento</th>
                <th>Cantidad</th>
            </tr>
        </thead>
        <tbody>
    
        <?php
            
        if($_POST) {
        
            while ($row = mysqli_fetch_array($query)) {
                echo '<tr id="op">
                            <td id="op"><input type="checkbox" name="busq" value="'.$row['titulo'].'">'.$row['titulo'].'</td>
                            <td id="op" align="center">$'.$row['precio_descuento'].'</td>
                            <td><input type="number" name="quantity"  value="1" min="1"></td>
                    </tr>';
            }

        }
        ?>
    
        </tbody>    
    </table>
        <input type="submit" value="Vender">
        <input type="reset" value="Reset" >
    </form>

    <script src="" async defer></script>
    <br>
  </body>
</html>