<?php

require_once 'Clases/conexion.php';
$basededatos = new Database;

$id_instituto = $_GET['id_instituto'];
$datos = $basededatos->db_consulta("SELECT * FROM instituto i INNER JOIN ram r 
ON i.id_instituto = r.id_instituto 
WHERE i.id_instituto=$id_instituto");
$instituto = $datos[0];
//$basededatos->cargarDatos($instituto,$datos);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="resources/css/estilos.css">
</head>

<body>
  <h3>Instituto</h3>
  <form action="procesar_formularios.php" method="post" id="formularioAlumno">
    <table>

      <tr>
        <td> <label for="notaPromocion">Nombre:</label> </td>
        <td> <input type="text" id="nombre" name="nombre" required maxlength="50" value="<?php echo ($instituto['nombre']) ?>"> </td>
        <td> <label for="notaPromocion">Nota de Promocion:</label></td>
      </tr>
      <tr>
        <td> <label for="direccion">Direccion:</label> </td>
        <td> <input type="text" id="direccion" name="direccion" required maxlength="50" value="<?php echo ($instituto['direccion']) ?>"> </td>
        <td> <select name="Promocion" id="Promocion" required>
            <option value="">--Seleccione nota--</option>
        </td>

        </td>
      </tr>

      <tr>
        <td><label for="correo_electronico">Correo electronico:</label></td>
        <td><input type="text" id="correo_electronico" name="correo_electronico" required maxlength="50" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain" value="<?php echo ($instituto['correo_electronico']) ?>"></td>

        <td> <label for="Regularizacion">Nota de Regularizacion:</label> </td>
      </tr>

      <tr>
        <td><label for="telefono">Telefono:</label></td>
        <td><input type="text" id="telefono" name="telefono" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}" maxlength="12" title="XXXX-XX-XXXX" value="<?php echo ($instituto['telefono']) ?>"></td>
        <td> <select name="notaRegularizacion" id="Regularizacion" required value="<?php echo ($instituto['pAsisRegularizacion']) ?>">
            <option value="">--Seleccione nota--</option>

        </td>
      </tr>

      <tr>
        <td><label for="CUE">CUE</label></td>
        <td><input type="number" id="CUE" name="CUE" required pattern="[0-9]{8}" maxlength="8" title="8 numeros" value="<?php echo ($instituto['CUE']) ?>"></td>

      </tr>
      <tr>
        <td><label for="pAsisPromocion">Porsentaje de Asistencias</label></td>
        <td><input type="range" name="pAsisPromocion" id="pAsisPromocion" style="width:200px;" required value= <?php echo ($instituto['pAsisPromocion']) ?> ></td>
        <td><span id="porcent1"><?php echo ($instituto['pAsisPromocion']) ?>%</span></td>

      </tr>
      <tr>
        <td><label for="pAsisRegularizacion">Porsentaje de Regularisacion</label></td>
        <td><input type="range" name="pAsisRegularizacion" id="pAsisRegularizacion" style="width:200px;" required value=<?php echo ($instituto['pAsisRegularizacion']) ?> ></td>
        <td><span id="porcent2"><?php echo ($instituto['pAsisRegularizacion']) ?>%</span></td>

      </tr>
      <input type="hidden" name="notaPromocion" id="notaPromocion">
      <input type="hidden" name="notaRegularizacion" id="notaRegularizacion">
      <input type="hidden" name="clase" value="institutoEdicion">
      <input type="hidden" name="id_instituto" value="<?php echo ($instituto['id_instituto']) ?>">
      <input type="hidden" name="id_ram" value="<?php echo ($instituto['id_ram']) ?>">
    </table>
    <button type="submit" id="ingresoInstituto">Ingresar</button>
  </form>



</body>
<script>
  function notas(id) {
    const sel = document.getElementById(id);
    for (i = 1; i < 11; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      sel.appendChild(option);
    }
  }
  notas('Promocion')
  document.getElementById('Promocion').addEventListener('change', () => {
    const promocion = document.getElementById('Promocion')
    document.getElementById("Regularizacion").innerHTML = '<option value="">--seleccione nota--</option>'; // Resetear materias
    const sel = document.getElementById('Regularizacion');
    for (i = 1; i < promocion.value; i++) {
      const option = document.createElement('option');
      option.value = i;
      option.textContent = i;
      sel.appendChild(option);
    }

  });
  document.getElementById("Regularizacion").addEventListener('change', () => {
    document.getElementById("notaPromocion").value = document.getElementById('Promocion').value
    document.getElementById("notaRegularizacion").value = document.getElementById('Regularizacion').value
  })

  addEventListener('load', inicio, false);

  function inicio() {
    document.getElementById('pAsisRegularizacion').addEventListener('change', cambioTemperatura, false);
    document.getElementById('pAsisPromocion').addEventListener('change', cambioTemperatura, false);

  }

  function cambioTemperatura() {

    if (document.getElementById('pAsisRegularizacion').value > document.getElementById('pAsisPromocion').value - 1) {
      document.getElementById('pAsisRegularizacion').value = document.getElementById('pAsisPromocion').value;
    }

    document.getElementById('porcent1').innerHTML = document.getElementById('pAsisPromocion').value + '%';
    document.getElementById('porcent2').innerHTML = document.getElementById('pAsisRegularizacion').value + '%';
  }

  function valorDefecto() {
    document.getElementById('Promocion').value = <?php echo ($instituto['notaPromocion']); ?>;

    document.getElementById('Regularizacion').value = <?php echo ($instituto['notaRegularizacion']); ?>;
    const sel = document.getElementById('Regularizacion');
    const option = document.createElement('option');
    option.value = <?php echo ($instituto['notaRegularizacion']); ?>;
    option.textContent = <?php echo ($instituto['notaRegularizacion']); ?>;
    sel.appendChild(option);
    sel.value = <?php echo ($instituto['notaRegularizacion']); ?>
  }
  valorDefecto();
</script>

</html>