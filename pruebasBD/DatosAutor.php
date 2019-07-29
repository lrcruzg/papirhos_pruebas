<?php
// ************************************************************************************************
//  Muestra los libros (co)escritos dado un autor 
// ************************************************************************************************

// id del autor de interés
$id = $_GET['autor'];

// nombre completo del autor de interés, solo se usa para mostrarlo
$name = $_GET['nombre'];

// crea la conexión a la db
require_once("db_connect.php");

$sql = "SELECT libros_aux.id_libros, titulo, coleccion, serie FROM libros_autores_aux
		JOIN libros_aux
			ON libros_aux.id_libros = libros_autores_aux.id_libros
		WHERE id_autores = '$id'";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>
<html>
<head>
	<meta charset="utf-8">
	<title>Libros por Autor</title>
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
        	<h2>Libros escritos por <?php echo $name; ?></h2>
			<table align="center">
				<thead>
					<tr>
						<th>Título</th>
						<th>Coleccíon</th>
						<th>Serie</th>
					</tr>
				</thead>
				<tbody>
				<?php
				while ($row = mysqli_fetch_array($query)) {
                    // Crea un link a DatosLibro.php con el título para mostrat los autores del libro "$row[titulo]"
                    // para esto necesita pasar el id_libros y el titulo por GET
					echo '<tr>
                            <td>
                                <a href="DatosLibro.php?libro='.$row['id_libros'].'&titulo='.utf8_encode($row['titulo']).'">'.
                                    utf8_encode($row['titulo']).'
                                </a>
                            </td>
		                    <td>'.utf8_encode($row['coleccion']).'</td>
		                    <td>'.utf8_encode($row['serie']).'</td>
						</tr>';
				}
				?>
				</tbody>
			</table>

		</div>
	</div>
	
	
</body>
</html>