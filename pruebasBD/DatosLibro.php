<?php
// ************************************************************************************************
//  Muestra los autores de un libro dado
// ************************************************************************************************

// id del libro de interés
$id = $_GET['libro'];

// título correspondiente al libro con id_libro "$id", solo lo uso para mostrar
// nombre sin tener que hacer el query (unir una tabla más para averiguarlo)
$lib_nombre = $_GET['titulo'];

// Crea la conexión a la db
require_once("db_connect.php");

$sql = "SELECT autores_aux.id_autores, nombre, apellido_paterno, apellido_materno FROM autores_aux 
        JOIN libros_autores_aux 
        ON autores_aux.id_autores = libros_autores_aux.id_autores 
        WHERE id_libros = '$id'";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Autores por libro</title>
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
          width: 50%;
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
    	<h2>Autores del libro <?php echo $lib_nombre; ?></h2>
		<table align="center">
			<thead>
				<tr>
					<th>Nombre</th>
				</tr>
			</thead>
			<tbody>
			<?php
				while ($row = mysqli_fetch_array($query)) {
                    // agrupa el nombre, apellido_paterno y apellido_materno en uno sólo string
                    $nombre_completo = utf8_encode($row['nombre']).' '.
                                utf8_encode($row['apellido_paterno']).' '.
                                utf8_encode($row['apellido_materno']);
                    // Crea un link a DatosAutor.php para mostrar los libros escritos por "$nombre_completo", usa el
                    // $row['id_autores'] y $nombre_completo y los pasa por GET para poder mostrar correctamente los datos
                    echo '<tr>
                            <td><a href="DatosAutor.php?autor='.$row['id_autores'].'&nombre='.$nombre_completo.'">'.
                            $nombre_completo.
                            '</a></td>
                          </tr>';
				}
			?>
			</tbody>
		</table>

	</div>
</div>
	
	
</body>
</html>