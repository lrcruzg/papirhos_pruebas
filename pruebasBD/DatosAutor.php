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
	<title>Autores</title>
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
<body>
	<nav>
        <a href="/PruebasBD/index.html">Inicio</a> |
        <a href="/PruebasBD/MuestraDatos.php">Autores</a> |
	</nav>
	<table align="center">
		<caption class="title"><b>Libros escritos por ...</caption>
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
</body>
</html>