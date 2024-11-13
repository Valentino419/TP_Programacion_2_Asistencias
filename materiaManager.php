<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar Nuevos</title>
    <link rel="stylesheet" href="resources/css/estilos.css">
    <style>
        /* Estilos para ocultar el formulario inicialmente */
        #formularioContainer {
            display: none;
            /* Oculto al inicio */
            margin-top: 10px;
        }
    
        /* Opcional: Estilos del formulario */
        label {
            display: block;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <h2>Presentin TM</h2>
    <table>
        <tr> <button type="button" onclick="location.href='http://localhost/Asistencias/main.php'">HOME</button>
             <button type="button" onclick="location.href='http://localhost/Asistencias/alta.php'">Nuevos</button>
        </tr>
        <tr>
            <td><label for="profesor">Selecciona un Profesor:</label>
                <select id="profesor">
                    <option value="">--Seleccione un profesor--</option>
                </select>
                <button type="button" id="EditarProfesor" disabled>Editar</button>
              
            </td>
            <td><label for="institutoid">Selecciona un Instituto:</label>
                <select id="institutoid">
                    <option value="">--Seleccione un Instituto--</option>
                </select>
                <button type="button" id="EditarInstituto" disabled>Editar</button>
            </td>
        </tr>
        <tr>
            <td><label for="materia">Materias:</label>
                <select id="materia" disabled>
                    <option value="">--Seleccione una materia--</option>

                </select>
            </td>
            <td><button type="button" id="nuevaMateria" disabled>Nueva Materia</button></td>
        </tr>
    </table>

    <h2></h2>
    <div class="tabs">

        <button class="tablinks" onclick="openTab(event, 'Vista1')">Tomar Asistencia</button>
        <button class="tablinks" onclick="openTab(event, 'Vista2')">ver Asistencias</button>
        <button class="tablinks" onclick="openTab(event, 'Vista3')">Inscribir Alumnos</button>
        <button class="tablinks" onclick="openTab(event, 'Vista4')">Calificaciones</button>

    </div>

    <div id="Vista1" class="tabcontent">
        <button type="button" id="verAlumnos" disabled>Ver Alumnos</button>
        <h2>Lista de Alumnos</h2>

        <form id="asistencias" action="test.php" method="post">
            <ul id="listaAlumnos">
                <!-- Lista de alumnos se mostrará aquí -->
            </ul>
            <button type="button" id="confirmarAsistencias" disabled>Confirmar Asistencias</button>
        </form>

    </div>

    <div id="Vista2" class="tabcontent">


        <label for="fecha_clase">Clases tomadas:</label>
        <select id="fecha_clase" disabled>
            <option value="">--Seleccione fecha--</option>
        </select>

        <button type="button" id="verAlumnos2" disabled>Ver Alumnos</button>

        <h2>Lista de Alumnos</h2>

        <ul id="listaAlumnos2">
            <!-- Lista de alumnos se mostrará aquí -->
        </ul>
        <button type="button" id="confirmarEdicionAsistencias" disabled>Confirmar</button>
    </div>

    <div id="Vista3" class="tabcontent">
        <button type="button" id="verAlumnos3" disabled>Ver Alumnos</button>
        <form id="asistencias2" action="test.php" method="post">
            <ul id="listaAlumnos3">
                <!-- Lista de alumnos se mostrará aquí -->
            </ul>
            <button type="button" id="inscribir" disabled>Confirmar inscripciones</button>
        </form>


    </div>
    <div id="Vista4" class="tabcontent">


        <table>
            <tr>
                <td> <select id="instancias_evaluativas" disabled>
                        <option value="">--Seleccione Instancia Evaluativa--</option>
                </td>

                <td><button type="button" id="nuevaEvaluacion" disabled>Nueva instancia Evaluativa</button></td>
            </tr>
            <tr>
                <td> <button type="button" id="verAlumnos4" disabled>Ver Alumnos</button></td>
            </tr>
        </table>
        
        <div id="formularioContainer">

            <form id="formEvaluaciones">
                <h2>Nueva Instancia Evaluativa</h2>
                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" maxlength="30" required>

                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required maxlength="100" style="width: 800px; height: 100px;"></textarea>

                <label for="fecha">Fecha:</label>
                <input type="date" id="fecha" name="fecha" required style="width: 120px; height: 20px;">

                <button type="button" id="confirmarNuevaEvaluacion">Nueva Evaluacion</button>
                <button type="button" id="nuevoRecuperatorio" disabled>Nuevo Recuperatorio</button>
                <button type="button" onclick="ocultarFormulario('formularioContainer')">Cerrar</button>
            </form>
        </div>
        <h2>Lista de Alumnos</h2>
        <form id=formListaAlumnos4>
            <ul id="listaAlumnos4">

                <!-- Lista de alumnos se mostrará aquí -->
            </ul>
        </form>
        <button type="button" id="enviarCalificaciones" disabled>Enviar Calificaciones</button>
    </div>

    <script src="resources\js\funciones.js"></script>
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

</body>