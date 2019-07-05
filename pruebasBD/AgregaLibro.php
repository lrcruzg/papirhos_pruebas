<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <title>Papirhos - Agregar Libro</title>
        <link type="image/x-icon" href="papirhos_im.ico" rel="icon" />
    </head>
    <br>

  <body>
    <h1 align="center">Agregar Libro</h1>
    <!-- Esta forma agarra el texto a meter en la base de datos-->
    <form action="agrega_libro.php" method="POST">
      <fieldset>
        <legend>Información del libro a agregar</legend>

        <table align="center">
            <tr>
                <td align="right">Título: </td>
                <td><input type="text" name="tit" required></td>
            </tr>

            <tr>
                <td align="right">Serie: </td>
                <td><input type="text" name="ser" required></td>
            </tr>

            <tr>
                <td align="right">Colección: </td>
                <td><input type="text" name="colecc" required></td>
            </tr>

            <tr>
                <td align="right">Núm de Serie: </td>
                <td><input type="text" name="numser" required></td>
            </tr>

        </table>
        <input type="submit" value="Submit" />
      </fieldset>
    </form>
    <script src="" async defer></script>
    <br>
  </body>
</html>