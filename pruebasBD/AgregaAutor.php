<?php
$Nombre = $ApellidoP = $ApellidoM = $message = "";

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// crea la conexión a la db
require_once("db_connect.php");

if($_POST) {

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $Nombre = test_input($_POST["Nombre"]);
        $ApellidoP = test_input($_POST["ApellidoPaterno"]);
        $ApellidoM = test_input($_POST["ApellidoMaterno"]);
    }

    // IMPORTANTE, los acentos no funcionan sin esto
    $acentos = $conn->query("SET NAMES 'utf8'");

    // verifica si hay otro autor en la base con el mismo nombre y apellidos y los cuenta
    $duplicado = "SELECT COUNT(nombre) AS num, id_autores FROM autores_aux
                WHERE nombre = '$Nombre' 
                AND  apellido_paterno = '$ApellidoP' 
                AND apellido_materno = '$ApellidoM'";

    $query = mysqli_query($conn, $duplicado);

    $row = mysqli_fetch_array($query);

    $esta_repetido = ((int)$row['num'] == 0) ? FALSE : TRUE;

    $nombre_completo = $Nombre." ".$ApellidoP." ".$ApellidoM; 
     
    if($esta_repetido) {
        $message = 'El autor <a href="DatosAutor.php?autor='.$row['id_autores'].'&nombre='.$nombre_completo.'">'.$nombre_completo.'</a> YA está en la base de datos';
    } else {    
        $sql = "INSERT INTO autores_aux (nombre, apellido_paterno, apellido_materno)
                VALUES ('$Nombre', '$ApellidoP', '$ApellidoM')";

        if ($conn->query($sql) === TRUE) {
            $message = "$nombre_completo fue agregado a la base de manera exitosa.";

        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();

}

?>

<html>
<head>
    <meta charset="utf-8">
    <title>Papirhos - Agregar Autor</title>
    <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    <link rel="stylesheet" type="text/css" href="css/menu2.css">
    <link rel="stylesheet" type="text/css" href="css/general.css">
    <link rel="stylesheet" type="text/css" href="css/media.css">
    <link rel="stylesheet" type="text/css" href="css/grid.css">
    <meta name="viewport" content="initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <style type="text/css">
        table {
            padding-left: 23%;
        }
        td {
            width: 40%;
            padding-bottom: 7px;
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

        input[type=submit], input[type=reset] {
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

        input[type=submit]:hover, input[type=reset]:hover {
            background-color: #ff8000;
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
            <h1 align="center">Agregar Autor</h1>
            <form action="AgregaAutor.php" method="POST">
                <table>
                    <tr>
                        <td><input type="text" name="Nombre" placeholder="Ingresa el Nombre" required></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="ApellidoPaterno" placeholder="Ingresa el Apellido Paterno" required></td>
                    </tr>
                    <tr>
                        <td><input type="text" name="ApellidoMaterno" placeholder="Ingresa el Apellido Materno"></td>
                    </tr>
                    <tr>
                        <td align="center">
                            <input type="reset" value="Reset">
                            <input type="submit" value="Agregar">                            
                        </td>                        
                    </tr>
                </table>
            </form>

            <?php
            if($_POST) {
                //echo "<h2>$message</h2>";
                // solo la uso para evitar problemas con los tipos de comillas
                $aux = "this.parentElement.style.display='none';";
                echo '<div class="alert">
                          <span class="closebtn" onclick="'.$aux.'">&times;</span> 
                          '.$message.'
                    </div>';
            }
            ?>
        </div>
    </div>

</body>
</html>