<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos - Ventas</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
        <style>
            table {
              font-family: arial, sans-serif;
              border-collapse: collapse;
            }

            td, th {
              border: 1px solid #dddddd;
              padding: 3px;
            }

            tr:nth-child(even) {
              background-color: #dddddd;
            }
        </style>
    </head>
    <br>

    <body>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "pruebasBD";

        $busqueda = $_POST["q"];

        // Crea la conexion
        $conn = new mysqli($servername, $username, $password, $dbname);

        // IMPORTANTE, los acentos no funcionan sin esto
        $acentos = $conn->query("SET NAMES 'utf8'");


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

        ?>

        <h2 align="center">Ventas</h2>
        <form>
            <table>
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
                    
                while ($row = mysqli_fetch_array($query)) {
                    echo '<tr>
                                <td><input type="checkbox" name="busq" value="'.$row['titulo'].'">'.$row['titulo'].'</td>
                                <td align="center">$'.$row['precio_descuento'].'</td>
                                <td><input type="number" name="quantity"  value="1" min="1"></td>
                        </tr>';
                }

                ?>

                </tbody>    
            </table>
            <input type="reset" value="Reset" >
            <input type="submit" value="Vender">
        </form>
        <br>
        <form action="index.html">
            <input type="submit" value="Regresar" />
        </form>

        <script src="" async defer></script>
        <br>
    </body>
</html>
