var vectorListaAlumnos

const db_api = 'http://localhost/Asistencias/db_api.php';
let ram = []
document.addEventListener('DOMContentLoaded', () => {
    const profesorSelect = document.getElementById('profesor');
    const materiaSelect = document.getElementById('materia');
    const institutoSelect = document.getElementById('institutoid');
    const nuevaMateriaBtn = document.getElementById('nuevaMateria');
    ////////
    const verAlumnosBtn = document.getElementById('verAlumnos');
    const listaAlumnos = document.getElementById('listaAlumnos');
    const confirmarAsistenciasBtn = document.getElementById('confirmarAsistencias');

    const listaAlumnos2 = document.getElementById('listaAlumnos2');
    const verAlumnosBtn2 = document.getElementById('verAlumnos2')
    const confirmarEdicionAsistenciasBtn = document.getElementById('confirmarEdicionAsistencias')
    const fechaSelect = document.getElementById('fecha_clase')


    const verAlumnosBtn3 = document.getElementById('verAlumnos3');
    const listaAlumnos3 = document.getElementById('listaAlumnos3');
    const confirmarInscripcionesBtn = document.getElementById('inscribir');

    const verAlumnosBtn4 = document.getElementById('verAlumnos4');
    const listaAlumnos4 = document.getElementById('listaAlumnos4');
    const confirmarNuevaEvaluacionBtn = document.getElementById('confirmarNuevaEvaluacion');
    const verFormNuevaEvaluacionBtn = document.getElementById('nuevaEvaluacion');
    const evaluacionesSelect = document.getElementById('instancias_evaluativas');
    const confirmarNuevoRecuperatorioBtn = document.getElementById('nuevoRecuperatorio');
    const confimrarCalificaciones = document.getElementById('enviarCalificaciones')

    const editarProfesorBtn = document.getElementById('EditarProfesor')
    const editarInstitutoBtn = document.getElementById('EditarInstituto')
    editarProfesorBtn.addEventListener('click', () => {
        location.href = `http://localhost/Asistencias/profesorEditar.php?id_profesores=${profesorSelect.value}`
    })
    editarInstitutoBtn.addEventListener('click', () => {

        location.href = `http://localhost/Asistencias/institutoEditar.php?id_instituto=${institutoSelect.value}`
    })

    CargarListasPI()

    function CargarListasPI() {
        fetch(db_api, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                opcion: "listarProfesores"
            })// envia el array como objeto

        })
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.nombre - b.nombre)
                data.forEach(profesor => {
                    const option = document.createElement('option');
                    option.value = profesor.id_profesores;
                    option.textContent = profesor.nombre + " " + profesor.apellido;
                    profesorSelect.appendChild(option);
                });
            });

        fetch(db_api, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                opcion: "listarInstitutos"
            })// envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                data.sort((a, b) => a.nombre - b.nombre)
                data.forEach(isntituto => {

                    const option = document.createElement('option');
                    option.value = isntituto.id_instituto;
                    option.textContent = isntituto.nombre;
                    institutoSelect.appendChild(option);
                });
            });
    }
    // Evento al seleccionar un profesor


    profesorSelect.addEventListener('change', () => {

        mostrarMaterias(profesorSelect, institutoSelect, materiaSelect, listaAlumnos)
        checkSelectValuesNewMateria()
       checkButtonState('EditarProfesor',profesorSelect)
    });
    institutoSelect.addEventListener('change', () => {
        mostrarMaterias(profesorSelect, institutoSelect, materiaSelect, listaAlumnos)
        checkSelectValuesNewMateria()
       
        checkButtonState('EditarInstituto',institutoSelect)
    });

    // Evento al seleccionar una materia
    materiaSelect.addEventListener('change', () => {


        if (materiaSelect.value) {

            MateriaSelectFiller(evaluacionesSelect, 'Seleccione Instancia Evaluativa', 'listarInstanciasEvaluativas', 'id_instancias_evaluativas', 'titulo')
            MateriaSelectFiller(fechaSelect, 'Seleccione Fecha', 'listarFechaAsistencias', 'fecha', 'fecha')
            verAlumnosBtn.disabled = false; // Habilitar botón de ver alumnos
            verAlumnosBtn3.disabled = false;
            verFormNuevaEvaluacionBtn.disabled = false;

            getRam(materiaSelect.value)
        } else {
            MateriaSelectFiller(evaluacionesSelect, 'Seleccione Instancia Evaluativa', 'listarInstanciasEvaluativas', 'id_instancias_evaluativas', 'titulo')
            MateriaSelectFiller(fechaSelect, 'Seleccione Fecha', 'listarFechaAsistencias', 'fecha', 'fecha')

            verAlumnosBtn.disabled = true; // Deshabilitar botón si no hay materia seleccionada
            verAlumnosBtn3.disabled = true;
            verFormNuevaEvaluacionBtn.disabled = true;
        }

        limpiarTablas(); // Limpiar lista de alumnos


    });
    verAlumnosBtn.addEventListener('click', () => {
        if (materiaSelect.value) {
            confirmarAsistenciasBtn.disabled = false; // Habilitar botón de tomar Asistencias
        } else {
            confirmarAsistenciasBtn.disabled = true; // Deshabilitar botón si no hay alumnos seleccionados
        }
    });
    // Evento al hacer clic en el botón de ver alumnos
    // Formulario 1 Asistencias
    verAlumnosBtn.addEventListener('click', () => {
        const materiaId = materiaSelect.value;
        limpiarTablas()
        vectorListaAlumnos = [];
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "alumnosRegistradosPorMateria", id_materia: materiaId }) // envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                dibujarTabla(data, 'listaAlumnos', ['Apellido', 'Nombre', 'DNI', 'Estado', 'Asistencia'], ['apellido', 'nombre', 'dni']);
                insertarbotonEstados(data, materiaId, 'listaAlumnos');
                insertarbotonAsistencias(data, 'listaAlumnos');
                data.forEach((alumno) => { sumarelemento(alumno) });
                const hoy = new Date();
                const fecha = hoy.toISOString().split('T')[0];

                yaPresentes(materiaSelect.value, fecha);
            })
            .catch(error => console.error('Error:', error));

    });
    confirmarAsistenciasBtn.addEventListener('click', () => {
        event.preventDefault();
        cumpleaños()
        result = confirm("desea confimrar asistencias?");
        // cumpleaños();

        if (result) {
            id_materia = materiaSelect.value;
            const hoy = new Date();
            const fecha = hoy.toISOString().split('T')[0];
            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "guardarAsistencisas", vectorListaAlumnos: vectorListaAlumnos, id_materia: id_materia, fecha: fecha }) // envia el array como objeto
            }).then(response =>
                response.json()
            ).
                then(data => {
                    console.log('Success:', data);

                    alert("asistencias guardadas")
                }).catch(error => console.error('Error:', error));

        }


    });
    //Formulario 2 Asistencias Anteriores







    ///////Formulario 3 Inscripciones///////////////////////////////////////////////////////////

    verAlumnosBtn3.addEventListener('click', () => {//poner notas
        const materiaId = materiaSelect.value;
        limpiarTablas();
        vectorListaAlumnos = [];
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "listarAlumnos" }) // envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                dibujarTabla(data, 'listaAlumnos3', ['Apellido', 'Nombre', 'DNI'], ['apellido', 'nombre', 'dni']);
                insertarBotonInscribir(data, 'listaAlumnos3');
                console.log(data)
                yaInscripto(materiaSelect.value, 'listaAlumnos3');
            }).catch(error => console.error('Error:', error));

    })
    verAlumnosBtn3.addEventListener('click', () => {
        if (materiaSelect.value) {

            confirmarInscripcionesBtn.disabled = false;
            // Habilitar botón de tomar Asistencias
        } else {
            confirmarInscripcionesBtn.disabled = true; // Deshabilitar botón si no hay alumnos seleccionados
        }
    });
    confirmarInscripcionesBtn.addEventListener('click', () => {
        event.preventDefault();
        result = confirm("confirmar inscripciones?");
        if (result) {
            id_materia = materiaSelect.value;

            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "inscribirAlumnosMateria", vectorListaAlumnos: vectorListaAlumnos, id_materia: id_materia }) // envia el array como objeto
            }).then(response =>
                response.json()
            ).
                then(data => {
                    let baja = 0
                    let inscriptos = 0
                    data.forEach(alumno => {
                        if (data['resultadoOperacion'] == 'inscripto') { inscriptos = +1 }
                        if (data['resultadoOperacion'] == 'dado de baja') {
                            baja = +1
                        }

                    })

                    if (inscriptos > 0) {
                        alert(inscriptos + ' alumnos inscriptos con exito')
                    }
                    if (baja > 0) { alert(baja + ' alumnos dados de baja exitosamente') }





                }).catch(error => console.error('Error:', error));

        }
    })

    nuevaMateriaBtn.addEventListener('click', () => {
        nombreMateria = prompt("ingrese nombre Materia",);
        if (nombreMateria == '') {


            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "nuevaMateria", nombre: nombreMateria, id_profesor: profesorSelect.value, id_instituto: institutoSelect.value }) // envia el array como objeto
            }).then(response =>
                response.json()
            ).
                then(data => {
                    if (data['resultadoOperacion'] == 'exito') {
                        alert('nueva materia creada exitosamente')
                        mostrarMaterias(profesorSelect, institutoSelect, materiaSelect, listaAlumnos)
                    }
                    else {
                        alert('ocurrio un error: no se pudo crear la nueva materia')
                        console.log(data);
                    }

                }).catch(error => console.error('Error:', error));
        }

    })

    //FORMULARIO 4 notas y Examenes
    verFormNuevaEvaluacionBtn.addEventListener('click', () => { mostrarFormulario("formularioContainer") });
    confirmarNuevaEvaluacionBtn.addEventListener('click', () => {
        event.preventDefault();
        form = document.getElementById("formEvaluaciones");
        if (form.checkValidity()) {
            alert("All required fields are filled!");
            result = confirm("confirmar inscripciones?");
            if (result) {
                titulo = document.getElementById('titulo').value
                descripcion = document.getElementById('descripcion').value
                fecha = document.getElementById('fecha').value
                id_recuperatorio = 0;
                nuevaInstanciaEvaluativa(titulo, descripcion, fecha, id_recuperatorio)
            }
        } else {
            alert("Please fill in all required fields.");
        }
    })
    evaluacionesSelect.addEventListener('change', () => {
        limpiarTablas()
        if (evaluacionesSelect.value) {
            confirmarNuevoRecuperatorioBtn.disabled = false;
            verAlumnosBtn4.disabled = false;

        } else {
            verAlumnosBtn4.disabled = true;
            confirmarNuevoRecuperatorioBtn.disabled = true;
        }

    })
    confirmarNuevoRecuperatorioBtn.addEventListener('click', () => {
        event.preventDefault();
        form = document.getElementById("formEvaluaciones");
        if (form.checkValidity()) {
            result = confirm("confirmar inscripciones?");
            if (result) {
                titulo = document.getElementById('titulo').value
                descripcion = document.getElementById('descripcion').value
                fecha = document.getElementById('fecha').value
                id_recuperatorio = evaluacionesSelect.value;
                nuevaInstanciaEvaluativa(titulo, descripcion, fecha, id_recuperatorio)
            }
        } else {
            alert("Please fill in all required fields.");
        }
    })
    verAlumnosBtn4.addEventListener('click', () => {
        if (materiaSelect.value) {
            confimrarCalificaciones.disabled = false; // Habilitar botón de tomar Asistencias
        } else {
            confimrarCalificaciones.disabled = true; // Deshabilitar botón si no hay alumnos seleccionados
        }
    })
    verAlumnosBtn4.addEventListener('click', () => {
        const materiaId = materiaSelect.value;
        limpiarTablas()
        vectorListaAlumnos = [];
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "alumnosRegistradosPorMateria", id_materia: materiaId }) // envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                dibujarTabla(data, 'listaAlumnos4', ['Apellido', 'Nombre', 'DNI', 'nota'], ['nombre', 'apellido', 'dni']);
                insertarImputNotas(data, 'listaAlumnos4')
                data.forEach((alumno) => { sumarelemento(alumno) });


            })
            .catch(error => console.error('Error:', error));
    })
    confimrarCalificaciones.addEventListener('click', () => {
        notas = []
        id_InstancisasEvaluativas = evaluacionesSelect.value
        form = document.getElementById("formListaAlumnos4");
        if (form.checkValidity()) {
            getNotas(notas)
            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "ingresarNotas", id_InstancisasEvaluativas: id_InstancisasEvaluativas, notas: notas }) // envia el array como objeto
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data);

                }).catch(error => console.error('Error:', error));
        }
        else {
            alert("Please fill in all required fields.");
        }


    })
    fechaSelect.addEventListener('change', () => {
        limpiarTablas()
        if (fechaSelect.value) {

            verAlumnosBtn2.disabled = false;

        } else {
            verAlumnosBtn2.disabled = true;
        }

    })
    verAlumnosBtn2.addEventListener('click', () => {
        if (materiaSelect.value) {
            confirmarEdicionAsistenciasBtn.disabled = false; // Habilitar botón de tomar Asistencias
        } else {
            confirmarEdicionAsistenciasBtn.disabled = true; // Deshabilitar botón si no hay alumnos seleccionados
        }
    })

    verAlumnosBtn2.addEventListener('click', () => {


        const fecha = fechaSelect.value
        const materiaId = materiaSelect.value;
        limpiarTablas()
        vectorListaAlumnos = [];
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "alumnosRegistradosPorMateria", id_materia: materiaId }) // envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                dibujarTabla(data, 'listaAlumnos2', ['Apellido', 'Nombre', 'DNI', 'Asistencia'], ['apellido', 'nombre', 'dni']);

                insertarbotonAsistencias(data, 'listaAlumnos2');
                data.forEach((alumno) => { sumarelemento(alumno) });

                yaPresentes(materiaSelect.value, fecha);
            })
            .catch(error => console.error('Error:', error));

    })
    confirmarEdicionAsistenciasBtn.addEventListener('click', () => {
        event.preventDefault();
        result = confirm("desea confimrar asistencias?");
        if (result) {
            id_materia = materiaSelect.value;
            fecha = fechaSelect.value
            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "guardarAsistencisas", vectorListaAlumnos: vectorListaAlumnos, id_materia: id_materia, fecha: fecha }) // envia el array como objeto
            }).then(response =>
                response.json()
            ).
                then(data => {
                    console.log('Success:', data);

                    alert("asistencias guardadas")
                }).catch(error => console.error('Error:', error));

        }


    });
    ////Funciones
    function MateriaSelectFiller(objeto, texto, fetchOption, valores, contenido) {
        const object = objeto
        object.innerHTML = '<option value="">--' + texto + '--</option>'; // Resetear el selcet
        if (materiaSelect.value) {
            object.disabled = false; // Habilitar select de fechas   


            limpiarTablas();
            id_materia = materiaSelect.value

            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    opcion: fetchOption, id_materia: id_materia
                })// envia el array como objeto"listarInstanciasEvaluativas"
            })
                .then(response => response.json())
                .then(data => {

                    data.forEach(elemento => {

                        const option = document.createElement('option');
                        option.value = elemento[valores];
                        option.textContent = elemento[contenido];
                        object.appendChild(option);
                    });
                });
        } else {
            object.disabled = true; // Deshabilitar select si no hay materia seleccionada        
        }


    }


    function getRam(id_materia) {
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "getRam", id_materia: id_materia }) // envia el array como objeto
        })
            .then(response => response.json()).then(data => { ram = data })

    }
    function nuevaInstanciaEvaluativa(titulo, descripcion, fecha, id_recuperatorio) {

        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "nuevaInstanciaEvaluativa", id_materia: materiaSelect.value, titulo: titulo, descripcion: descripcion, fecha: fecha, id_recuperatorio: id_recuperatorio }) // envia el array como objeto
        }).then(response =>
            response.json()
        ).
            then(data => {

                if (data['resultadoOperacion'] == 'exito') {
                    alert('nueva instancia evaluativa creada exitosamente')

                }
                else {
                    alert('ocurrio un error: no se pudo crear la nueva instancia evaluativa')
                    console.log(data);
                }
                MateriaSelectFiller(evaluacionesSelect, 'Seleccione Instancia Evaluativa', 'listarInstanciasEvaluativas', 'id_instancias_evaluativas', 'titulo')

                ocultarFormulario("formularioContainer");
                document.getElementById('titulo').value = ""
                document.getElementById('descripcion').value = ""
                document.getElementById('fecha').value = ""

            }).catch(error => console.error('Error:', error));
    }

    function limpiarTablas() {
        ocultarFormulario("formularioContainer");
        vectorListaAlumnos = [];

        listaAlumnos.innerHTML = '';
        listaAlumnos2.innerHTML = '';
        listaAlumnos3.innerHTML = '';
        listaAlumnos4.innerHTML = '';
    }
    function checkSelectValuesNewMateria() {
        if (profesorSelect.value && institutoSelect.value) {
            nuevaMateriaBtn.disabled = false;
        } else {
            nuevaMateriaBtn.disabled = true;
        }
    }
    function mostrarMaterias(profesorSelect, institutoSelect, materiaSelect, listaAlumnos) {

        const profesorId = profesorSelect.value;
        const institutoid = institutoSelect.value;

        if (profesorSelect.value) {
           
            materiaSelect.disabled = false; // Habilitar botón de ver alumnos       
        } else {
           
            materiaSelect.disabled = true; // Deshabilitar botón si no hay materia seleccionada        
        }

        materiaSelect.innerHTML = '<option value="">--Seleccione una materia--</option>'; // Resetear materias
        limpiarTablas();
        vectorListaAlumnos = [];
        if (profesorId) {
            fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "materiaInstitutoProfesor", campo: 4, id_profesor: profesorId, id_instituto: institutoid }) // envia el array como objeto
            })
                .then(response => response.json())
                .then(data => {
                    data.forEach(materia => {
                        const option = document.createElement('option');
                        option.value = materia.id_materia;

                        option.textContent = materia.nombre;
                        materiaSelect.appendChild(option);
                    });
                    materiaSelect.disabled = false;
                });
        }
    }

    ///////////////////////////////////////////////////////////
    function sumarelemento(elemento) {
        console.log()
        vectorListaAlumnos.push({ "id_alumno": elemento["id_alumno"], "estado": false, elemento });//, "fecha_nacimiento": elemento['fecha_nacimiento'] 

    }

    function botonPresente(index, id) {

        if (vectorListaAlumnos[index]["estado"] === false) {

            vectorListaAlumnos[index]["estado"] = true;
            document.getElementById(id).innerText = "Presente";
            document.getElementById(id).style.backgroundColor = "green";
            document.getElementById(id).style.color = "white";
        } else {
            vectorListaAlumnos[index]["estado"] = false; // Cambiar estado
            document.getElementById(id).innerText = "Ausente";
            document.getElementById(id).style.backgroundColor = "red";
            document.getElementById(id).style.color = "";

        }

    }
    function yaPresentes(id_materia, fecha) {

        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "getPresentes", id_materia: id_materia, fecha: fecha }) // envia el array como objeto
        }
        ).then(response =>
            response.json()
        ).
            then(data => {


                vectorListaAlumnos.forEach((alumno, index) => {


                    data.forEach((alumno2) => {

                        if (alumno["id_alumno"] == alumno2["id_alumno"]) {
                            botonPresente(index, "btn_" + alumno['id_alumno'])
                        }
                    }
                    )
                }
                )


            }
            )
    }
    function yaInscripto(id_materia, contenedor) {
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "getInscriptos", id_materia: id_materia }) // envia el array como objeto
        }
        ).then(response =>
            response.json()
        ).
            then(data => {

                vectorListaAlumnos.forEach((alumno, index) => {

                    data.forEach((alumno2) => {

                        if (alumno["id_alumno"] == alumno2["id_alumno"]) {

                            botonInscripcion(index, "btn_" + contenedor + "_" + alumno['id_alumno'])
                        }
                    }
                    )
                }
                )


            }
            ).catch(error => console.error('Error:', error));
    }

function checkButtonState(button_id,select){
   const button= document.getElementById(button_id)
    if (select.value) {
        
        button.disabled = false; // Habilitar botón de ver alumnos       
    } else {
        button.disabled = true;
       // Deshabilitar botón si no hay materia seleccionada        
    }
}

    /////////////////////Tablas////////////////
    function consultaEstado(id_alumno, id_materia) {
        mensaje = ""


        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "consultarAsistencias", id_materia: id_materia, id_alumno: id_alumno }) // envia el array como objeto
        })
            .then(response => response.json())
            .then(data => {
                const diasClase = data.dias_clases
                const asistencias = data.asistencias
                const porcentaje = data.porcentaje

                mensaje = `Dias de Clase: ${diasClase}\nTotal Asistencias: ${asistencias}\nPorcentaje de asistencias: ${Math.trunc(porcentaje * 100)}%\nEstado: `;

                let condicion;
                if (porcentaje * 100 >= ram.pAsisPromocion) {
                    condicion = "PROMOCIONA";
                } else if (porcentaje * 100 >= ram.pAsisRegularizacion) {
                    condicion = "LIBRE";
                } else {
                    condicion = "RECURSA";
                }

                mensaje += condicion;

            }).then(fetch(db_api, {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ opcion: "cosultarNotas", id_materia: id_materia, id_alumno: id_alumno }) // envia el array como objeto
            })
                .then(response => response.json())
                .then(data => {
                    let acumulador = 0
                    let contador = 0
                    let promedio = 0
                    let desaprobado = false
                    mensaje = mensaje + "\n Calificaciones"
                    data.forEach(element => {
                        mensaje = mensaje + `\n  ${element.titulo}, nota: (${element.calificacion}) condicion: `
                        if (element.calificacion >= ram.notaPromocion) {
                            mensaje = mensaje + "APROBADO"
                        } else {
                            if (element.calificacion >= ram.notaRegularizacion) { mensaje = mensaje + "REGULARIZADO" } else {
                                mensaje = mensaje + "DESAPROBADO"
                                Desaprobados = true
                            }
                        }
                        contador = contador + 1
                        acumulador = acumulador + element.calificacion
                    })
                    promedio = acumulador / contador
                    mensaje = mensaje + `\n Promedio: ${(promedio)} `

                    if (desaprobado) { mensaje = mensaje + " DESAPROBADO" } else {
                        if (promedio >= ram.notaPromocion) {
                            mensaje = mensaje + "APROBADO"
                        } else {
                            if (promedio >= ram.notaRegularizacion) { mensaje = mensaje + "REGULARIZADO" } else { mensaje = mensaje + "DESAPROBADO" }
                        }
                    }

                    alert(mensaje)
                })).catch(error => console.error('Error:', error));


    }
    function dibujarfilas(row, datos, nombresDatos) {
        Object.keys(datos).forEach(key => {
            if (nombresDatos.includes(key.toString())) {
                const td = document.createElement('td');
                td.textContent = datos[key];
                row.appendChild(td);
            }
        });

    }
    function dibujarTabla(data, contenedor, headers, datosUsados) {
        data.sort((a, b) => a.apellido - b.apellido);
        const tableContainer = document.getElementById(contenedor);
        const table = document.createElement('table');
        table.id = `${contenedor}_table`
        table.border = '1';
        // Crear encabezados de la tabla
        const headerRow = document.createElement('tr');
        //const headers = ['Nombre', 'Apellido', 'DNI', 'Estado', 'Asistencia'];

        headers.forEach(header => {
            const th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        headerRow.id = `${contenedor}_headderRow`
        table.appendChild(headerRow);
        data.forEach((elemento, index) => {
            const row = document.createElement('tr');
            row.id = `${contenedor}_row_${index}`
            dibujarfilas(row, elemento, datosUsados)
            table.appendChild(row);

        });
        tableContainer.appendChild(table);

    }
    function insertarbotonEstados(data, materiaId, contenedor) {
        var n = document.getElementById(`${contenedor}_table`).rows.length - 1;
        for (index = 0; index < n; index++) {

            //var row = document.getElementById(`${contenedor}_row_${index}`);
            agregarBotonEstados(contenedor, index, data[index], materiaId)
          
            // n.appendChild(row);
        }

    }
    function agregarBotonEstados(contenedor, index, alumno, materiaId) {
        const row = document.getElementById(`${contenedor}_row_${index}`)
        const actionsTd = document.createElement('td');
        const button = document.createElement('button');
        button.type = 'button';
        button.id = `btn_${contenedor}${alumno['id_alumno']}`;
        button.style = " background-color: #0091ff";
        button.textContent = 'Cosultar';
        button.onclick = () => consultaEstado(alumno['id_alumno'], materiaId); // Llama a la función para mostrar situacion
        actionsTd.appendChild(button);

        actionsTd.dataset.id = alumno['id_alumno'];
        row.appendChild(actionsTd);
    }
    function insertarbotonAsistencias(data, contenedor) {
        var n = document.getElementById(`${contenedor}_table`).rows.length - 1;
        for (index = 0; index < n; index++) {
            AgregarBotonAsistencias(contenedor, index, data[index])
            agregarBotonEditar(contenedor, index, data[index])
        }

    }
    function AgregarBotonAsistencias(contenedor, index, alumno) {
        const row = document.getElementById(`${contenedor}_row_${index}`)
        const actionsTd = document.createElement('td');
        const button = document.createElement('button');
        button.type = 'button';
        button.id = `btn_${alumno['id_alumno']}`;
        button.style.backgroundColor = "red";
        button.style.color = "";
        button.textContent = 'Ausente';
        button.onclick = () => botonPresente(index, `btn_${alumno['id_alumno']}`); // Llama a la función para cambiar el estado
        actionsTd.appendChild(button);
        actionsTd.dataset.id = alumno['id_alumno'];
        row.appendChild(actionsTd);
    }

    function insertarBotonInscribir(data, contenedor) {
        var n = document.getElementById(`${contenedor}_table`).rows.length - 1;
        for (index = 0; index < n; index++) {
            AgregarBotonInscripcion(contenedor, index, data[index])
        }

    }
    function AgregarBotonInscripcion(contenedor, index, alumno) {
        console.log(alumno)
        console.log(index)
        console.log(`btn_${contenedor}_${alumno['id_alumno']}`)
        const row = document.getElementById(`${contenedor}_row_${index}`)
        const actionsTd = document.createElement('td');
        const button = document.createElement('button');
        button.type = 'button';
        button.id = `btn_${contenedor}_${alumno['id_alumno']}`;
        button.style.backgroundColor = "red";
        button.style.color = "";
        button.textContent = 'Inscribir';
        button.onclick = () => botonInscripcion(index, `btn_${contenedor}_${alumno['id_alumno']}`); // Llama a la función para cambiar el estado
        actionsTd.appendChild(button);
        actionsTd.dataset.id = alumno['id_alumno'];
        row.appendChild(actionsTd);

        sumarelemento(alumno)
    }
    function botonInscripcion(index, id) {

        const button = document.getElementById(id)
        if (vectorListaAlumnos[index]["estado"]) {
            vectorListaAlumnos[index]["estado"] = false;
            button.innerText = "Inscribir";
            document.getElementById(id).style.backgroundColor = "red";

        } else {
            vectorListaAlumnos[index]["estado"] = true;
            button.textContent = 'Inscripto';
            document.getElementById(id).style.backgroundColor = "green";
        }


    }
    function agregarBotonEditar(contenedor, index, alumno) {
        const row = document.getElementById(`${contenedor}_row_${index}`)
        const actionsTd = document.createElement('td');
        const button = document.createElement('button');
        button.type = 'button';
        button.id = `btnEditar_${contenedor}${alumno.id_alumno}`;
        button.style = " background-color: #9191ff";
        button.textContent = 'Editar';
        button.onclick = function() {
            location.href = `http://localhost/Asistencias/alumnoEditar.php?id_alumno=${alumno.id_alumno}`;
        };
        actionsTd.appendChild(button);

        actionsTd.dataset.id = alumno.id_alumno;
        row.appendChild(actionsTd);
    }


    

    function agregarImputNotas(contenedor, alumno) {

        const row = document.getElementById(`${contenedor}_row_${index}`)
        const actionsTd = document.createElement('td');
        const input = document.createElement('input');
        input.type = 'number';
        input.id = `nota_${contenedor}_${alumno['id_alumno']}`;
        input.style = "width: 100px; height: 20px;"
        input.max = 10;
        input.min = 1;
        actionsTd.appendChild(input);
        actionsTd.dataset.id = alumno['id_alumno'];
        row.appendChild(actionsTd);

        sumarelemento(alumno)
    }
    function insertarImputNotas(data, contenedor) {
        var n = document.getElementById(`${contenedor}_table`).rows.length - 1;
        const notasAlumnos = []
        fetch(db_api, {
            method: 'POST', headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ opcion: "getNotasDeInstanciaEvaluativa", id_InstancisasEvaluativas: evaluacionesSelect.value }) // envia el array como objeto
        })
            .then(response => response.json()).then(data => { notasAlumnos = data })
        console.log(notasAlumnos)
        for (index = 0; index < n; index++) {
            agregarImputNotas(contenedor, data[index])
        }

    }
    /////////////////////////////////////////
    function getNotas(result) {
        const table = document.getElementById("listaAlumnos4_table");
        const rows = table.querySelectorAll("tr");

        rows.forEach(row => {
            const input = row.querySelector("input[type='number']"); // Get the input in the row

            if (input) {
                const value = input.value; // Get the input value
                const dataId = input.closest("td").getAttribute("data-id"); // Get the data-id of the <td>

                result.push({ id_alumno: dataId, calificacion: value })

            }
        });
        // return result;
    }

    function cumpleaños() {
        hoy = new Date()
        const dia = hoy.getDate();
        const mes = hoy.getMonth() + 1;
        cumple = false;
        console.log(vectorListaAlumnos)
        let mensaje = "Hoy es el cumpleaños de los Siguentes alumnos";
        vectorListaAlumnos.forEach(estudiante => {

            const [year, mescumple, diacumple] = (estudiante.elemento.fecha_nacimiento).split("-")
            console.log(dia + '/' + mes + '//' + diacumple + '/' + mescumple)

            if (mes == mescumple && dia == diacumple) {
                cumple = true;
                console.log(estudiante.elemento.nombre + ' ' + estudiante.elemento.apellido)
                mensaje = mensaje + '\n' + estudiante.elemento.nombre + ' ' + estudiante.elemento.apellido
            }
        })
        mensaje = mensaje + '\n Que lo pasen muy Feliz'
        if (cumple) {
            alert(mensaje);
        }
    }



});


function ocultarFormulario(id) {
    const formularioContainer = document.getElementById(id);
    formularioContainer.style.display = "none"; // Mostrar el formulario

}
function mostrarFormulario(id) {
    const formularioContainer = document.getElementById(id);
    formularioContainer.style.display = "block"; // Mostrar el formulario
}

