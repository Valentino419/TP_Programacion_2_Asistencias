<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Nuevos</title>
    <link rel="stylesheet" href="resources/css/estilos.css">
</head>

<body>
    <h2>Presentin TM</h2>
    <h2>Nuevo</h2>
    <div class="tabs">
        <button class="tablinks" onclick="openTab(event, 'Vista1')">Nuevo Alumnos</button>
        <button class="tablinks" onclick="openTab(event, 'Vista2')">Nuevo Profesor</button>
        <button class="tablinks" onclick="openTab(event, 'Vista3')">Nuevo Insitituto </button>
        <button class="tablinks" onclick="openTab(event, 'Vista4')">Nueva Materia </button>
    </div>

    <div id="Vista1" class="tabcontent">
        <h3>Alumno</h3>
        <form action="procesar_formularios.php" method="post" id="formularioAlumno">
            <table>

                <tr>
                    <td> <label for="nombre">Nombre:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required maxlength ="50" > </td>
                </tr>
                <tr>
                    <td> <label for="apellido">Apellido:</label> </td>
                    <td> <input type="text" id="apellido" name="apellido" required maxlength ="50" title=" hasta 50 characters"> </td>
                </tr>
                <tr>
                    <td><label for="dni">DNI:</label></td>
                    <td> <input type="number" id="dni" name="dni" required pattern="[0-9]{8}" maxlength="8" title="8 numeros"></td>
                </tr>
                <tr>
                    <td><label for="fecha_nacimiento">Fecha de Nacimiento:</label></td>
                    <td><input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required></td>
                </tr>
                <tr>
                    <td><label for="correo_electronico">Correo electronico:</label></td>
                    <td><input type="text" id="correo_electronico" name="correo_electronico" maxlength ="50" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain"></td>
                </tr>

                <tr>
                    <td><label for="telefono">Telefono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}" maxlength ="12" title="XXXX-XX-XXXX"></td>
                </tr>

                    <input type="hidden" name="clase"  value ="alumno" >

            </table>
            <button type="submit" id="ingresoAlumno">Ingresar</button>
        </form>

    </div>

    <div id="Vista2" class="tabcontent">
        <h3>Profesor</h3>
        <form action="procesar_formularios.php" method="post" id="formularioProfesor">
            <table>

                <tr>
                    <td> <label for="nombre">Nombre:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required  maxlength ="50" > </td>
                </tr>
                <tr>
                    <td> <label for="apellido">Apellido:</label> </td>
                    <td> <input type="text" id="apellido" name="apellido" required  maxlength ="50"> </td>
                </tr>
                <tr>
                    <td><label for="dni">DNI:</label></td>
                    <td> <input type="text" id="dni" name="dni" required pattern="[0-9]{8}"  maxlength ="8" title="8 numeros"></td>
                </tr>

                <tr>
                    <td><label for="correo_electronico">Correo electronico:</label></td>
                    <td><input type="text" id="correo_electronico" name="correo_electronico" required  maxlength ="50" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain"></td>
                </tr>

                <tr>
                    <td><label for="telefono">Telefono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}"  maxlength ="12" title="XXXX-XX-XXXX"></td>
                </tr>

                <tr>
                    <td><label for="legajo">Tegajo</label></td>
                    <td><input type="number" id="legajo" name="legajo" required pattern="[0-9]{8}"  maxlength ="8"></td>
                </tr>

            </table>
            <input type="hidden" name="clase" value="profesor">
            <button type="submit" id="ingresoProfesor">Ingresar</button>
        </form>

    </div>

    <div id="Vista3" class="tabcontent">
        <h3>Instituto</h3>
        <form action="procesar_formularios.php" method="post" id="formularioAlumno">
            <table>

                <tr>
                    <td> <label for="notaPromocion">Nombre:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required maxlength ="50"> </td>
                    <td> <label for="notaPromocion">Nota de Promocion:</label></td>
                </tr>
                <tr>
                    <td> <label for="direccion">Direccion:</label> </td>
                    <td> <input type="text" id="direccion" name="direccion" required maxlength ="50"> </td>
                    <td> <select name="Promocion" id="Promocion" required>
                            <option value="">--Seleccione nota--</option>
                    </td>

                    </td>
                </tr>

                <tr>
                    <td><label for="correo_electronico">Correo electronico:</label></td>
                    <td><input type="text" id="correo_electronico" name="correo_electronico" required maxlength ="50" pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" title=" characters@characters.domain"></td>

                    <td> <label for="Regularizacion">Nota de Regularizacion:</label> </td>
                </tr>

                <tr>
                    <td><label for="telefono">Telefono:</label></td>
                    <td><input type="text" id="telefono" name="telefono" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{4}" maxlength ="12" title="XXXX-XX-XXXX"></td>
                    <td> <select name="notaRegularizacion" id="Regularizacion" required>
                            <option value="">--Seleccione nota--</option>

                    </td>
                </tr>

                <tr>
                    <td><label for="CUE">CUE</label></td>
                    <td><input type="number" id="CUE" name="CUE" required pattern="[0-9]{8}"maxlength ="8" title="8 numeros"></td>

                </tr>
                <tr>
                    <td><label for="pAsisPromocion">Porsentaje de Asistencias</label></td>
                    <td><input type="range" name="pAsisPromocion" id="pAsisPromocion" style="width:200px;" required></td>
                    <td><span id="porcent1">50%</span></td>

                </tr>
                <tr>
                    <td><label for="pAsisRegularizacion">Porsentaje de Regularisacion</label></td>
                    <td><input type="range" name="pAsisRegularizacion" id="pAsisRegularizacion" style="width:200px;" required></td>
                    <td><span id="porcent2">50%</span></td>

                </tr>
                <input type="hidden" name="notaPromocion" id="notaPromocion">
                <input type="hidden" name="notaRegularizacion" id="notaRegularizacion">
                <input type="hidden" name="clase" value="instituto">
            </table>
            <button type="submit" id="ingresoInstituto">Ingresar</button>
        </form>
    </div>
    <div id="Vista4" class="tabcontent">
        <form action="procesar_formularios.php" method="post" id="formularioAlumno">
            <table>
                <tr>
                    <td>

                        <label for="institutoid">Selecciona un Instituto:</label>
                    </td>
                    <td>
                        <select id="institutoid">
                            <option value="">--Seleccione un Instituto--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="profesorid">Selecciona un Profesor:</label>
                    </td>
                    <td> <select id="profesorid">
                            <option value="">--Seleccione un profesor--</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td> <label for="nombre">Nombre de Materia:</label> </td>
                    <td> <input type="text" id="nombre" name="nombre" required maxlength ="15"> </td>
                </tr>

            </table>
            <input type="hidden" name="profesor_id" id="profesor_id" value="0">
            <input type="hidden" name="instituto_id" id="instituto_id" value="0">
            <input type="hidden" name="clase" value="materia">
            <button type="submit" id="ingresoMateria" disabled>Ingresar</button>
        </form>

    </div>

    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;

            // Esconder todos los contenidos de las pestañas
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remover la clase 'active' de todas las pestañas
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }

            // Mostrar la pestaña seleccionada y añadir 'active' a su botón
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }

        // Abrir la primera pestaña por defecto
        document.querySelector(".tablinks").click();
    </script>
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
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const profesorSelect = document.getElementById('profesorid');
            const institutoSelect = document.getElementById('institutoid');
            const submitButton = document.getElementById('institutoid');
            fetch('http://localhost/Asistencias/db_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        opcion: "listarProfesores"
                    }) // envia el array como objeto
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(profesor => {
                        const option = document.createElement('option');
                        option.value = profesor.id; // Suponiendo que cada profesor tiene un id
                        option.textContent = profesor.nombre + " " + profesor.apellido; // Cambia 'nombre' si es necesario
                        profesorSelect.appendChild(option);
                    });
                });

            fetch('http://localhost/Asistencias/db_api.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        opcion: "listarInstitutos"
                    }) // envia el array como objeto
                })
                .then(response => response.json())
                .then(data => {
                    data.forEach(isntituto => {
                        const option = document.createElement('option');
                        option.value = isntituto.id; // Suponiendo que cada isntituto tiene un id
                        option.textContent = isntituto.nombre; // Cambia 'nombre' si es necesario
                        institutoSelect.appendChild(option);
                    });
                });
            document.getElementById('profesorid').addEventListener('change', () => {
                checkSelectValues()
                document.getElementById('profesor_id').value = document.getElementById('profesorid').value
            })
            document.getElementById('institutoid').addEventListener('change', () => {
                checkSelectValues()
                document.getElementById('instituto_id').value = document.getElementById('institutoid').value
            })

            function checkSelectValues() {
                if (profesorSelect.value && institutoSelect.value) {
                    ingresoMateria.disabled = false;
                } else {
                    ingresoMateria.disabled = true;
                }


            }
        })
    </script>
</body>


</html>