<?php
// ************************************************************************************************
//  Maneja la modificación de inventario, la idea es bastante similar a Ventas.php
//  Hace una búsqueda para después elegir los libros a modificar el número de ejemplares que se
//  se tienen declarados, (aún por escribir) se crea un registro de las modificaciones y se actualiza
//  la cantidad en la base (tabla de inventario)
// ************************************************************************************************

// Crea la conexión a la db
require_once("db_connect.php");

// IMPORTANTE, hace funcionar los acentos en las querys
$acentos = $conn->query("SET NAMES 'utf8'");

// Espera a que se haga la búsqueda para realizar la consulta
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

    // hace la busqueda (muestra el título y el numero de ejemplares) con el primer argumento (antes del primer + si es que hay)
    $sql = "SELECT DISTINCT libros_aux.id_libros, titulo, ejemplares FROM inventario_aux
            JOIN libros_aux
            ON libros_aux.id_libros = inventario_aux.id_libros
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

    // los resultados los ordena por orden alfabético con respecto al título
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
    <title>Actualiza Inventario</title>
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

        .boton_actualizar {
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

            <h1 align="center">Actualiza Inventario</h1>

            <form action="ActualizaInventario.php" method="GET">
                <input type="text" name="q" placeholder="Título, Autor, Colección, Número">
                <input type="submit" value="Buscar">
            </form>

            <?php
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
                                    <th>Ejemplares</th>
                                </tr>
                            </thead>
                            <tbody>';

                            while ($row = mysqli_fetch_array($query)) {
                                echo '<tr>
                                        <td><input class="input enable" type="checkbox" name="busq[]" value="'.$row['id_libros'].'">'.$row['titulo'].'</td>
                                        <td align="center"><input type="number" name="cantidad[]" value="'.$row['ejemplares'].'" min="0" disabled></td>
                                    </tr>';
                            }

                            echo '
                            </tbody>    
                        </table>
                         <div class="boton_actualizar">
                            <input type="submit" value="Actualizar">
                        </div>
                    </form>';
                }

            }

            ?>
            <!-- https://stackoverflow.com/questions/29596147/relate-a-checkbox-with-another-input -->
            <script type="text/javascript">
                $('.enable').change(function(){
                    var set =  $(this).is(':checked') ? false : true;
                    $(this).closest('td').siblings().find('input').attr('disabled',set);  
                });
            </script>

            <?php
            if($_POST) {
                $venta = $_POST['busq'];
                $cant = $_POST['cantidad'];
                for($i = 0; $i < count($venta); $i++) { 
                    $sql_venta  = "UPDATE inventario_aux
                    SET ejemplares = '$cant[$i]'
                    WHERE id_libros = '$venta[$i]'";

                    $query2 = mysqli_query($conn, $sql_venta);

                    if (!$query2) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    } else {
                        // solo la uso para evitar problemas con los tipos de comillas
                        $aux = "this.parentElement.style.display='none';";
                        echo '<div class="alert">
                                      <span class="closebtn" onclick="'.$aux.'">&times;</span> 
                                      <strong>¡Cambio exitoso!</strong>
                                      Ahora hay '.$cant[$i].' ejemplares de '.$venta[$i].'
                                </div>';
                    }
                }
            }

            ?>

        </div>
    </div>
    
</body>
</html>