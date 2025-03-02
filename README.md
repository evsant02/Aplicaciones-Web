# Aplicaciones-Web

PRUEBAS

Ya está subida la estructura que hay que seguir para la práctica 2

Y este es el README del profe:

0. Dos páginas HTML.
1. Dividir la intefaz en varios ficheros para reutilizarla.
    a. Crear e incluir en index.php y contenido.php los ficheros
        •	cabecera.php
        •	sidebarIzq.php
        •	sidebarDer.php
        •	pie.php

2. Crear "script de vistas" y "script de apoyo para las vistas"
    a. Crear carpetas includes/comun

3. Crear "plantilla.php"
    a. Utilizarla desde index.php y contenido.php

4. Crear Login.php
    a. Crear "procesarLogin.php"

5. Proteger "contenido.php". Esta página es solo para usuarios registrados.

6. En la cabecera, escribir el nombre del usuario logeado y dar la posibilidad de hacer "logout"
    a. Crear "logout"

7. Crear BBDD
    a. Crear config.php
    b. Crear carpeta "Usuario" - Usuarios - UsuarioDB
    c. Modificar "procesarLogin.php" para que busque en BBDD
    
//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

8. Aplicar POO a formulario de login (patrón Template Method)
    a. Crear la clase formBase.php
        - Método "Manage" orquesta los métodos genéricos y especificos definidos en la subclase
    b. Crear la clase loginForm.php
    c. Utilizar loginForm desde login.php
    d. Eliminar usuarios.php y procesarLogin.php

9. Crear formulario de registro.
    a. Crear clase registerForm.php (retocar createFields, process)
    b. Crear método create en usuario.php
    b. Crear register.php
    c. Crear la opción "Registro" en cabecera.php

10. Desacoplar scripts de apoyo para las vistas (formularios) del acceso a datos
    a. Crear la interfaz IUser
    b. usuario implementa IUser
        - Quitar métodos estáticos y poner constructor público
    c. Crear userFactory
    d. En loginForm y registerForm usar userFactory

11. Crear userMock (para test unitarios?)
    a. Crear clase userMock
    b. Cambiar userFactory

12. Refactorizar "Active Record" a tres capas: AppService, DAO y DTO
    a. Crear UserDto
    b. Crear userDAO
    c. Cambiar la interfaz IUser
    d. Cambiar userFactory
    e. Crear userAppService como singleton -> implementa las funciones de negocio (casos de uso)
    f. En loginForm y registerForm usar userAppService

//////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

13. Crear clase "Application"
    a. Mantiene el estado global de la aplicación a través de instancia única.
    b. Gestiona una única conexión a BBDD
    c. Modificar fichero config.php
        i. Establecer soporte de UTF-8, localización (idioma y país) y zona horaria
        ii. Eliminar función getConexionBD() y reemplazar por llamada a Application->init. 
        iii. Registrar método shutdown para cerrar la conexión a BBDD
        iv. Utilizar Aplicacion::getInstance()->getConexionBd(); en UserDAO.php. Quitar includes(config.php)
        v. Utilizar require_once("includes/config.php"); en todos los scripts de vistas. Quitar sessio_start (esto lo hace el método init)

14. Crear clase baseDAO
    a. utilizar métodos de baseDAO desde UserDAO

15. Sentencias preparadas
    a. Refactorizar UserDAO para utilizar sentencias preparadas

16. Encriptar password
    a. En UserDAO crear método estático "hashPassword" y "testHashPassword"
    b. Utilizar los métodos "create" y "login".
    c. Eliminar usuarios de BBDD y crear nuevos a través de la aplicación.

17. Patrón PRG
    a. Añadir atributo privado $atributosPeticion en clase "application" e inicializarlo en método "init".
    b. Añadir en clase "application" los métodos "putAtributoPeticion" y "getAtributoPeticion".
    c. Añadir mensaje en "registerForm".
    d. Modificar "index.php" para mostrar el mensaje.

18. Gestor global de Excepciones
    a. Modificar tabla "Usuarios", columna "UserName" es única.
    b. Insertar registro repetido: excepción no controlada.
    c. Añadir gestor de excepciones en config.php.
    d. Insertar registro repetido, comprobar log: xampp/apache/logs/error.log

19. Exepciones de dominio
    a. Crear "userAlreadyExistException"
    b. En "userDAO", método "create" lanzar la excepción "userAlreadyExistException"
    c. En "registerForm" gestionar la excepcion