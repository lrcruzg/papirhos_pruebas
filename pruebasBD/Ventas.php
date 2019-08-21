<?php
// ************************************************************************************************
//  Maneja las ventas hechas en Papirhos, consiste en hacer la búsqueda del libro a vender,
//  elegir uno o más libros y especificar la cantidad de ejemplares vendidos por libro, y el precio
//  el cual puede ser el precio de lista o el precio con descuento
//  Actualiza el inventario y crea un registro por cada venta con los datos anteriores 
// ************************************************************************************************

// crea la conexión a la db
require_once("db_connect.php");

// IMPORTANTE, hace funcionar los acentos en las querys
$acentos = $conn->query("SET NAMES 'utf8'");

// Espera a que sea hecha la búsqueda para realizar la consulta
if($_GET) {
    $busqueda = $_GET["q"];

    $busqueda = trim($busqueda);
    $busqueda = stripslashes($busqueda);
    $busqueda = htmlspecialchars($busqueda);

    // parte la búsqueda con el separador "+"
    $busqueda_separada = explode("+", $busqueda);


    $sql_vista_autores_nombre_completo = "CREATE VIEW autores_nombre_completo AS
                                        SELECT id_autores, concat(nombre,' ',apellido_paterno,' ',apellido_materno) as nombre_completo 
                                        FROM autores_aux";

    $query_vista = mysqli_query($conn, $sql_vista_autores_nombre_completo);


    // hace la busqueda (muestra el título, precio y disponibilidad) con el primer argumento (antes del primer + si es que hay)
    $sql = "SELECT  DISTINCT libros_aux.id_libros, titulo, precio_descuento, ejemplares FROM libros_aux
            JOIN precios_libro
            ON precios_libro.id_libros = libros_aux.id_libros
            JOIN inventario_aux
            ON precios_libro.id_libros = inventario_aux.id_libros    
            JOIN libros_autores_aux
            ON libros_autores_aux.id_libros = libros_aux.id_libros
            JOIN autores_nombre_completo
            ON autores_nombre_completo.id_autores = libros_autores_aux.id_autores
            WHERE titulo LIKE '%$busqueda_separada[0]%'
            OR coleccion LIKE '%$busqueda_separada[0]%'
            OR num_serie LIKE '%$busqueda_separada[0]%'
            OR nombre_completo LIKE '%$busqueda_separada[0]%'";

    // si hay más argumentos también los agrega a la búsqueda
    for($i = 1; $i < count($busqueda_separada); $i++) { 
        $busq_aux = $busqueda_separada[$i];
        $sql = $sql." OR titulo LIKE '%$busq_aux%' 
                    OR coleccion LIKE '%$busq_aux%'
                    OR num_serie LIKE '%$busq_aux%'
                    OR nombre_completo LIKE '%$busq_aux%'";
    }

    // los resultados los ordena alfabeticamente con respecto al título
    $sql = $sql." ORDER BY titulo ASC";

    $query = mysqli_query($conn, $sql);

    if (!$query) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            padding: 3px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        li a, .dropbtn {
            display: inline-block;
            text-align: center;
            text-decoration: none;
        }
        li a:hover, .dropdown:hover .dropbtn {
            background-color: none;
        }
        li.dropdown {
            display: inline-block;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #678;
            min-width: 150px;
        }
        .dropdown-content a {
            text-decoration: none;
            display: block;
            text-align: left;
            padding-left: 4px;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }
        
        input[type=text] {
            background-color: #f2f2f2;
            width: 90%;
            border: 1px solid transparent;
            background-color: #f2f2f2;
            padding: 12px;
            font-size: 17px;
            color: #456;
        }

        input[type=submit] {
            background-color: darkorange;
            color: #fff;
            cursor: pointer;
            border: 1px solid transparent;
            padding: 12px;
            font-size: 15px;
        }

        input[type=number] {
            padding: 4px;
        }

        input[type=submit]:hover {
            background-color: orange;
        }

        .boton_vender {
            padding: 20px 1%;
        }

        .alert {
            padding: 20px;
            background-color: #4CAF50;
            color: white;
            margin-bottom: 15px;
        }

        .closebtn {
            margin-left: 15px;
            color: white;
            font-weight: bold;
            float: right;
            font-size: 22px;
            line-height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .closebtn:hover {
            color: black;
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

        <div id="menuencabezado"></div>
        <script>
            $(function(){
                $("#menuencabezado").load("menu_encabezado.html");
            });
        </script>

        <div id="contenido">

            <h1 align="center">Ventas</h1>

            <form action="Ventas.php" method="GET">
                <input type="text" name="q" placeholder="Título, Autor, Colección, Número">
                <input type="submit" value="Buscar">
            </form>

            <?php
            // Espera a que se haga la búsqueda para mostrar los datos del libro requerido
            if($_GET) {
                if(mysqli_num_rows($query) == 0) {
                    echo "<h2>No hay resltados que coincidan con la búsqueda \"$busqueda\"</h2>";
                } else {
                    echo '
                    <br>
                    <form method="post">
                        <table>
                            <caption class="title"><b>Resultados de "'.$busqueda.'"</caption>
                            <thead>
                                <tr>
                                    <th>Título</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Disponibles</th>
                                </tr>
                            </thead>
                            <tbody>';
                            // Muestra cada libro que coincida con la búsqueda 
                            while ($row = mysqli_fetch_array($query)) {
                                $precio_de_lista = ($row['precio_descuento'])*2;
                                // no permite vender más libros de los que hay disponibles (según inventario), aunque sólo lo evita el html, se puede hacer también
                                // en php al momento de hacer el query aunque no sé si es demasiada precaución
                                echo '<tr>
                                        <td><input class="input enable" type="checkbox" name="busq[]" value="'.$row['id_libros'].'">'.$row['titulo'].'</td>
                                        <td align="center">
                                            <select name="precio[]" disabled>
                                                <option value="'.$row['precio_descuento'].'">$'.$row['precio_descuento'].'</option>
                                                <option value="'.$precio_de_lista.'">$'.$precio_de_lista.'</option>
                                            </select>
                                        </td>
                                        <td align="center"><input type="number" name="cantidad[]" value="1" min="1" max="'.$row['ejemplares'].'" disabled></td>
                                        <td align="center">'.$row['ejemplares'].'</td>
                                    </tr>';
                            }

                            echo '
                            </tbody>    
                        </table>
                        <div class="boton_vender">
                            <input type="submit" value="Vender">
                        </div>
                    </form>';
                }

            }

            ?>
            <!-- https://stackoverflow.com/questions/29596147/relate-a-checkbox-with-another-input -->
            <script type="text/javascript">
                $('.enable').change(function(){
                    var set =  $(this).is(':checked') ? false : true;
                    $(this).closest('td').siblings().find('select').attr('disabled',set); 
                    $(this).closest('td').siblings().find('input').attr('disabled',set);
                });
            </script>

            <?php
            if($_POST) {
                // Los elementos seleccionado (con el checkbox habilitado) se guardan en arrays
                $libro_vendido = $_POST['busq'];  // id del libro vendido
                $cant = $_POST['cantidad'];       // cantidad de ejemplares vendidos del libro 
                $precio = $_POST['precio'];       // precio unitario del libro
                for($i = 0; $i < count($libro_vendido); $i++) {
                    // Se actualiza el inventario eliminando "$cant[i]" de ejemplares del libro
                    // "$libro_vendido[i]" en la base de datos
                    $sql_venta  = "UPDATE inventario_aux
                                    SET ejemplares = ejemplares - '$cant[$i]'
                                    WHERE id_libros = '$libro_vendido[$i]'";

                    // Se crea el registro con las datos anteriores, además de la fecha y hora de la venta
                    $sql_registro = "INSERT INTO registro_ventas (id_libros, cantidad, precio_por_ejemplar) 
                                    VALUES ('$libro_vendido[$i]', '$cant[$i]', $precio[$i])";

                    $query2 = mysqli_query($conn, $sql_venta);
                    $query3 = mysqli_query($conn, $sql_registro);

                    if (!$query2) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    } else {
                        // solo la uso para evitar problemas con los tipos de comillas
                        $aux = "this.parentElement.style.display='none';";

                        if($cant[$i] > 1) {
                            echo '<div class="alert">
                                      <span class="closebtn" onclick="'.$aux.'">&times;</span> 
                                      Venta de '.$cant[$i].' ejemplares de '.$libro_vendido[$i].' exitosa!
                                </div>';
                        } else {
                            echo '<div class="alert">
                                      <span class="closebtn" onclick="'.$aux.'">&times;</span> 
                                      Venta de un ejemplar de '.$libro_vendido[$i].' exitosa!
                                </div>';
                        }
                    }
                }
            }

            ?>

        </div>
    </div>
</body>
</html>