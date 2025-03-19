# Aplicaciones-Web

Las funcionalidades previamente planificadas para nuestra aplicación web son las siguientes:

    Registro de usuarios:Permite a los voluntarios y a los usuarios independientes registrarse en la plataforma mediante un formulario en el que proporcionan sus datos personales y de contacto. Una vez completado el registro, podrán acceder a su perfil y gestionar su participación en las actividades.
        Disponible para: Gente ajena que quiera registrarse

    Gestión de las actividades: Los administradores tienen acceso a un panel de control donde pueden crear, modificar y eliminar actividades. Los administradores son los encargados de proponer las actividades y publicarlas en la plataforma, donde posteriormente los voluntarios y usuarios que estén interesados, podrán inscribirse.
        Disponible para: Adminsitradores

    Registro de usuarios independientes en las actividades: Los usuarios independientes registrados pueden ver las actividades disponibles y apuntarse a aquellas que les interesen. También pueden consultar los detalles de cada actividad, como la fecha, el horario y la disponibilidad de plazas.
        Disponible para: Usuarios independientes registrados

    Registro de los voluntarios en las actividades: Los voluntarios pueden registrarse en las actividades como monitores. Podrán dirigir las actividades y coordinar la participación de los usuarios inscritos.
        Disponible para: Voluntarios registrados
    
    Donar dinero: Los donantes pueden acceder a una sección específica donde pueden realizar contribuciones económicas al proyecto de manera segura.
        Disponible para: Donantes

    Página de perfil del usuario: Cada usuario registrado dispone de un perfil personal donde puede visualizar sus datos, consultar las actividades en las que está inscrito, así como su historial de participación en eventos y actividades pasadas.
        Disponible para: Usuarios que estén registrados

Para esta práctica número 2 se han implementado por completo (al 100%) las funcionalidades relacionadas con el registro de usuarios de cualquier tipo (inicio de sesión, registro y cierre de sesión) y con la gestión de las actividades de mano de los administradores, ya que son los únicos que pueden acceder a esta funcionalidad (crear, modificar, visualizar y eliminar todas las actividades).

La diferencia entre estas funcionalidades y las que se completarán en las próximas prácticas es su grado de completitud. Estas funcionalidades están conectadas con la base de datos, haciendo uso de las tablas usuarios y actividades y, por tanto, su funcionamiento ya es completo. A diferencia del resto de funcionalidades, las cuales no están conectadas a la base de datos y por tanto únicamente se han codificado sus vistas principales y de apoyo ejemplificanfo como quedarán cuando se completen sus respectivas funcionalidades e interactuen con la base de datos. 

Por tanto, las funcionalidades que se llevarán a cabo en próximas entregas son: el registro de usuarios independientes (los ancianos) en las actividades, el registro de los voluntarios en las actividades, las donaciones de dinero y la página de perfil del usuario de cualquier tipo. Esta última funcionalidad, la del perfil, está casi implementada por completo, a falta de poder modificar la estructura en la que se visualizan los datos del usuario, ya que esta si está conectada a la base de datos.

Aunque las funcionalidades que hacen uso de otras tablas de la base de datos diferentes a usuarios y actividades no estén implementadas completamente, la base de datos si lo está. La base de datos cuenta ya con todas las tablas que harán falta en el futuro.