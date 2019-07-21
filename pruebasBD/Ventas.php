<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pruebasBD";

$busqueda = $_POST["q"];

$busqueda = trim($busqueda);
$busqueda = stripslashes($busqueda);
$busqueda = htmlspecialchars($busqueda);

// Crea la conexion
$conn = new mysqli($servername, $username, $password, $dbname);

// IMPORTANTE, los acentos no funcionan sin esto
$acentos = $conn->query("SET NAMES 'utf8'");

// Revisa la conexion
if ($conn->connect_error) {
    die("Conexion fallida: " . $conn->connect_error);
}

$sql = "SELECT libros_aux.id_libros, titulo, precio_descuento FROM libros_aux
JOIN precios_libro
    ON precios_libro.id_libros = libros_aux.id_libros
WHERE titulo LIKE '%$busqueda%' ORDER BY titulo ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Ventas</title>
    <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    <link rel="stylesheet" type="text/css" href="css/menu2.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/grid.css">
    <meta name="viewport" content="initial-scale=1">
    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 50%;
        }

        td, th {
          /*border: 1px solid black;*/
          padding: 3px;
        }

        tr:nth-child(even) {
          background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div id="contenedor">

        <div id="encabezado">
          <div id="logoizq" onclick="window.open('http://www.unam.mx');" style="cursor:pointer;">
          </div>
          <div id="logomid">
          </div>
          <div id="logoder" onclick="window.open('http://www.matem.unam.mx');" style="cursor:pointer;">
          </div>
        </div>

        <div id="menuencabezado">
            <nav>
                <ul>
                    <li>
                        <a href="/PruebasBD/index.html">Inicio</a>
                    </li>
                    <li>
                        <a href="/PruebasBD/MuestraAutores.php">Autores</a>
                    </li>
                    <li>
                        <a href="/PruebasBD/MuestraLibros.php">Libros</a>
                    </li>
                    
                </ul>
            </nav>
        </div>

        <div id="contenido">

            <h2 align="center">Ventas</h2>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
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
                                    <td><input class="input enable" type="checkbox" name="busq" value="'.$row['id_libros'].'">'.$row['titulo'].'</td>
                                    <td align="center">$'.$row['precio_descuento'].'</td>
                                    <td align="center"><input type="number" name="quantity" value="1" min="1" disabled></td>
                            </tr>';
                    }

                    ?>

                    </tbody>    
                </table>
                <input type="submit" value="Vender">
            </form>

            <!-- https://stackoverflow.com/questions/29596147/relate-a-checkbox-with-another-input -->
            <script type="text/javascript">
                $('.enable').change(function(){
                var set =  $(this).is(':checked') ? false : true;
                $(this).closest('td').siblings().find('input').attr('disabled',set);  
                });
            </script>

            <script src="" async defer></script>

        </div>
    </div>
  
</body>
</html>