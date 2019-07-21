<?php
$id = $_GET['libro'];
$lib_nombre = $_GET['titulo'];

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

$sql = "SELECT autores_aux.id_autores, nombre, apellido_paterno, apellido_materno FROM libros_autores_aux
		JOIN autores_aux
			ON autores_aux.id_autores = libros_autores_aux.id_autores
		WHERE autores_aux.id_autores = '$id'";

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
            $name = utf8_encode($row['nombre']).' '.
                        utf8_encode($row['apellido_paterno']).' '.
                        utf8_encode($row['apellido_materno']);
            echo '<tr>
                    <td><a href="DatosAutor.php?autor='.$row['id_autores'].'&nombre='.$name.'">'.
                    $name.
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