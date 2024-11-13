# TP_Programacion_2_Asistencias
Presentin es una palicacion web que permite llevar el registro de asistencieas y examenes del entorno escolar 

## Tabla de Contenidos
1. [Instalación](#instalación)
2. [Uso](#uso)
3. [Estructura del Proyecto](#estructura-del-proyecto)
4. [Contribuciones](#contribuciones)
5. [Licencia](#licencia)

 1 ## Instalación
se deve contar con un entorno de php y servidor apache instalado
recomiendo instalar laragon para eso 
https://laragon.org/download/
una ves se descarge la carpeta del projecto se devera colocar dentro de 
las carpetas WWW de laragon la raiz del proyecto e iniciar los servidores
una vez iniciado se podra dirigir al boton web de la app que abrira la pantalla de la aplicacion

2. [Uso](#uso)
   una ves en la pagina se encontrara con una pantalla de login, el usuario es admin 1234 y la contraseña es 1234
   aun estoy trabajando en eso
   una ves dentro se encontara en una pagina en blanco con dos botones
   Nuevos
   el de nuevo lo lleva a la pagina de altas, alli podra ingresar alumnos, insitutos materias y profesores
   tenga en cuenta que para crear una nueva materia debe existir al menos un profesor y un instituto en la base de datos
   la pestaña de insituto cuenta con la opcion de difinir los distintos criterios de evaluacion
   los valores de la nota de regularizacion apareseran una ves elija un valor para la nota de Promocion
   el valor de la barra de asistencias para regularizar no puede superar la de promocion por lo que se ajusta automaticamente
   una ves carge los que desee podra utilizar la pagina de asistencias 
en la pagina de asistencias se encontradra con 3 selectores y varios botones
para poder ver a los alumnos debe seleccionar un profesor, una materia y una ves echo eso podra interacutar con las pestañas de abajo
debajo de la barra de seleccion de profesores se encontrara con un boton que dice editar, simila debajo de la barra de insitituciones.
si lo preciona sera llevado a una nueva pagina donde podra hacerle cambios al profesor o insitituto seleccionado
a un costado hay un boton para crear una nueva materia, para poder usarlo tanto la barra de profesores como la de institutos deben tener algo seleccionado.
debajo de estos comandos se encuantea una pestañas que puede utilizar. los botones seran habiitados una ves haya una materia seleccionada

en la pestaña de inscribir alumnos una ves hagaa click en mostrar se desplegara una lista de todos los alumnos que haya guardados en ese momento.
desde alli podra inscribirlos o darlos de baja de la materia que desee. una ves termine de seleccinarlos presione sobre confirmar inscripciones para guardar los cambios.

ahora que los alumnos estan anotados podra usar las otras 3 pestañas.
la principal es la de tomar asistencias. alli se desplegara una lista de los alumnos inscriptos a la materia seleccionada. desde alli podra tomar o quitar las asistencisa del dia, ver el estado(disas asistidos porcentaje de asistencias, notas de examenes, y promedio) o ir a editar sus datos. una ves termine de tomar asistencias precione confirmar para guardar los datos
una ves termine de tomar asistencias.
en la pestaña de ver asistencias, podra volver a cualquier fecha que haya tomado asistencieas y ver quienes estuvieron presentes, tambien se pueden realizar cambios al estado de asistenciea desde esta pestaña

por ultimo la ventana de calificaciones: en ella podra crea instancias evaluativas, sus respectivos recuperatorios, y calificar a los alumnos. 
para crear una nueva calificacion debe primero tener seleccionada una materia. 



