<?php
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
	<h1>Tabla de Libros</h1>
    <nav>
        <a href="/PruebasBD/index.html">Inicio</a> |
        <a href="/PruebasBD/MuestraAutores.php">Autores</a> |
        <a href="/PruebasBD/MuestraLibros.php">Libros</a> |
    </nav>

	<table class="data-table" align="center">
		<caption class="title"><b>Libros</caption>
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
	                    	<a href="DatosAutor.php?autor='.$row['id_libros'].'">'.
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
</body>
</html>