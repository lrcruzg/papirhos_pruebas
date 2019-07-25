<?php
// crea la conexión a la db
require_once("db_connect.php");

$sql = "SELECT * FROM libros_aux ORDER BY id_libros ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Libros</title>
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
                    <li>
                        <a href="/PruebasBD/Ventas.php">Ventas</a>
                    </li>
                </ul>
            </nav>
        </div>

        <div id="contenido">

			<h1 align="center">Tabla de Libros</h1>

			<table class="data-table" align="center">
				<thead>
					<tr>
						<th>Id</th>
						<th>Título</th>
						<th>Colección</th>
						<th>Serie</th>

					</tr>
				</thead>
				<tbody>
				<?php
				while ($row = mysqli_fetch_array($query)) {
					echo '<tr>
							<td align="center">'.$row['id_libros'].'</td>
		                    <td>
		                    	<a href="DatosLibro.php?libro='.$row['id_libros'].'&titulo='.utf8_encode($row['titulo']).'">'.
		                    		utf8_encode($row['titulo']).'
		                    	</a>
		                    </td>
		                    <td>'.
		                    	utf8_encode($row['coleccion']).'
		                    </td>
		                    <td>'.
		                    	utf8_encode($row['serie']).
		                    '</td>
						</tr>';
				}
				?>
				</tbody>		
			</table>

		</div>
	</div>
	
</body>
</html>