# TP_Programacion_2_Asistencias
**Presentin** es una aplicación web que permite llevar el registro de asistencias y exámenes en un entorno escolar. Esta herramienta facilita el manejo de datos de alumnos, profesores, institutos, y materias, y permite registrar tanto la asistencia como las calificaciones en distintas instancias evaluativas.

## Tabla de Contenidos
1. [Instalación](#instalación)
2. [Uso](#uso)


## Instalación
Para ejecutar este proyecto, necesitas un entorno que soporte PHP y un servidor Apache. Recomiendo instalar [Laragon](https://laragon.org/download/) para este propósito.

### Pasos de Instalación:
1. Descarga y extrae el proyecto en la carpeta `www` de Laragon.
2. Inicia los servidores Apache y MySQL desde la interfaz de Laragon.
3. Accede a la aplicación desde el botón "Web" en Laragon o abre tu navegador y ve a `http://localhost/nombre_del_proyecto`.

## Uso
Al acceder a la aplicación, te encontrarás con una pantalla de inicio de sesión. Usa las siguientes credenciales:
- **Usuario**: `admin`
- **Contraseña**: `1234`

> **Nota**: Actualmente, el sistema de autenticación es básico, y la seguridad está en desarrollo.

### Navegación Principal
1. **Página de Altas (Nuevos)**:
   - Aquí podrás registrar **alumnos**, **institutos**, **materias**, y **profesores**.
   - Para crear una nueva **materia**, asegúrate de que ya existan un profesor y un instituto en la base de datos.
   - En la pestaña de **institutos**, puedes definir criterios de evaluación, como:
     - **Nota de Promoción**: Selecciona una nota y elige el valor de regularización según el valor de promoción.
     - **Porcentaje de Asistencia para Regularizar**: Este no puede exceder el porcentaje para promoción; se ajusta automáticamente.

2. **Página de Asistencias**:
   - Selecciona un **profesor** y/o una **materia** para activar las pestañas.
   - Desde aquí, puedes:
     - **Editar**: Botones disponibles para actualizar la información del profesor o instituto seleccionado.
     - **Crear Nueva Materia**: Disponible solo cuando un profesor e instituto están seleccionados.

#### Pestañas de la Página de Asistencias
- **Inscribir Alumnos**: Muestra una lista de alumnos y te permite inscribir o dar de baja en la materia seleccionada. Presiona **Confirmar Inscripciones** para guardar los cambios.
- **Tomar Asistencias**: Lista de alumnos inscritos donde podrás registrar su asistencia del día. Incluye:
  - Estado de cada alumno (días asistidos, porcentaje de asistencia, notas de exámenes, promedio).
  - Opciones para editar datos o cambiar el estado de asistencia. Confirma para guardar los datos.
- **Ver Asistencias**: Revisa la asistencia de cualquier fecha registrada y realiza cambios si es necesario.
- **Calificaciones**:
  - Crea instancias evaluativas y recuperatorios para calificar alumnos.
  - Completa el formulario para la evaluación. Selecciona un **recuperatorio** cuando esté habilitado.
  - El sistema considera automáticamente la nota más alta entre la evaluación y su recuperatorio.





