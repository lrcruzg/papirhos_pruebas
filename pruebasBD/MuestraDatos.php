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

$sql = "SELECT * FROM autores_aux ORDER BY id_autores ASC";

$query = mysqli_query($conn, $sql);

if (!$query) {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>

<html>
<head>
	<meta charset="utf-8">
	<title>Datos de Autor</title>
</head>
<body>
	<h1>Tabla de Autores</h1>
    <form action="index.html">
	    <input type="submit" value="Regresar" />
	</form>
	<table class="data-table">
		<caption class="title">Autores</caption>
		<thead>
			<tr>
				<th>ID Autores</th>
				<th>Nombre</th>
				<th>Apellido Paterno</th>
				<th>Apellido Materno</th>
			</tr>
		</thead>
		<tbody>
		<?php
			while ($row = mysqli_fetch_array($query)) {
				echo '<tr>
						<td>'.$row['id_autores'].'</td>
	                    <td>'.$row['nombre'].'</td>
						<td>'.$row['apellido_paterno'].'</td>
						<td>'.$row['apellido_materno'].'</td>
					</tr>';
			}
		?>
		</tbody>
		
	</table>
</body>
</html>

