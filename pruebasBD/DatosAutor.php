<?php
$id = $_GET['autor'];

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

$sql = "SELECT titulo, coleccion, serie FROM libros_autores_aux
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
        	<h2>Libros Escritos por ...</h2>
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
						echo '<tr>
								<td>'.utf8_encode($row['titulo']).'</td>
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