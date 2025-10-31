# DW-2DAM-ENTREGA-FUTBOL

[![GitHub release (latest by date)](https://img.shields.io/github/v/release/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL)](https://github.com/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL/releases)
[![GitHub contributors](https://img.shields.io/github/contributors/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL)](https://github.com/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL/graphs/contributors)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

---

## 📝 Descripción del Proyecto

Este repositorio contiene la **entrega final** de la asignatura **Desarrollo Web en Entorno Cliente/Servidor (DW)** del ciclo **2DAM**.

El proyecto es una aplicación web de gestión y visualización de datos relacionados con el mundo del fútbol, desarrollado utilizando **PHP nativo (puro)** para la lógica de negocio y **MySQL** para la persistencia de datos.

**Objetivo principal:** Administrar y consultar información de equipos, partidos y usuarios de una liga de fútbol, demostrando el uso de PHP y MySQL bajo un patrón de diseño DAO.

## 🚀 Características Principales

* **Autenticación y Sesiones Seguras:** Implementación de un sistema completo de **Login y Registro** (`app/login.php`, `app/signup.php`) que maneja las sesiones de usuario (`utils/SessionHelper.php`) para controlar el acceso a la aplicación.
* **Gestión de Equipos (CRUD):** Permite a los usuarios autorizados (administradores) realizar las operaciones **CRUD** (Crear, Leer, Actualizar, Eliminar) sobre la entidad de Equipos.
* **Patrón DAO (Data Access Object):** Uso de una capa de persistencia (`persistence/DAO`) para separar la lógica de negocio de la lógica de acceso a datos, garantizando un código más modular.
* **Sistema de Conexión Flexible:** La conexión a la base de datos MySQL se gestiona mediante la clase `PersistentManager`, que lee las credenciales de un archivo JSON (`persistence/conf/credentials.json`).
* **Diseño Responsivo con Bootstrap:** La interfaz de usuario está completamente adaptada a diferentes dispositivos (móvil, tablet, escritorio) gracias a la librería **Bootstrap 5.3.8**.
* **Integración con HeidiSQL:** La estructura de la base de datos se puede gestionar fácilmente con herramientas como HeidiSQL, utilizando el script SQL proporcionado.

## 📦 Estructura del Proyecto

Una visión general de la distribución de archivos y carpetas más relevantes:

DW-2DAM-ENTREGA-FUTBOL/ ├── app/ # Scripts para lógica de autenticación (login, signup, logout) ├── assets/ │ └── bootstrap-5.3.8-dist/ # Archivos estáticos de Bootstrap y JS ├── persistence/ # Capa de acceso a datos y configuración de la DB │ ├── DAO/ # Clases DAO (EquipoDAO, PartidoDAO, UserDAO) │ ├── conf/ # Configuración de la DB (PersistentManager.php, credentials.json) │ └── scripts/ # Archivo SQL para la creación de la DB ├── templates/ # Archivos de la interfaz reutilizables (ej: header.php, footer.php) ├── utils/ # Clases de utilidad (ej: SessionHelper.php) ├── equipos.php # Vista principal de gestión de equipos ├── index.php # Página de inicio ├── partidos.php # Vista de listado de partidos ├── partidosEquipo.php # Vista de partidos por equipo específico └── README.md


## 🛠️ Tecnologías Utilizadas

| Categoría | Tecnología | Versión |
| :--- | :--- | :--- |
| **Backend** | PHP (Nativo) | 7.x / 8.x |
| **Base de Datos** | MySQL | [Versión utilizada] |
| **Gestor de DB (Opcional)** | HeidiSQL | [Versión utilizada] |
| **Frontend** | HTML5, CSS3, JavaScript (Vanilla) | - |
| **Framework/Librería CSS** | Bootstrap | 5.3.8 |

## ⚙️ Instalación y Configuración

Sigue estos pasos para levantar el proyecto en un entorno de servidor local.

### Prerrequisitos

Asegúrate de tener instalados y configurados los siguientes componentes:

* **Servidor Web con PHP:** XAMPP, WAMP, MAMP o un servidor Apache configurado.
* **PHP:** Versión 7.x o superior.
* **MySQL:** Servidor de bases de datos.
* **Cliente de Base de Datos (Opcional):** HeidiSQL, phpMyAdmin, MySQL Workbench.

### Pasos

1.  **Clonar el repositorio:**
    ```bash
    git clone [https://github.com/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL.git](https://github.com/SrAlvarado/DW-2DAM-ENTREGA-FUTBOL.git)
    cd DW-2DAM-ENTREGA-FUTBOL
    ```

2.  **Configurar el Servidor Local:**
    * Mueve la carpeta `DW-2DAM-ENTREGA-FUTBOL` al directorio raíz de tu servidor (ej: `htdocs` en XAMPP).

3.  **Configurar la Base de Datos (MySQL):**
    * Inicia tus servicios de MySQL.
    * Utiliza tu cliente de DB (HeidiSQL, phpMyAdmin, etc.) para:
        * Crear una nueva base de datos.
        * Importar el script SQL para crear las tablas y los datos iniciales desde el archivo: `persistence/scripts/futbol_BD_Markel_Alvarado.sql`.

4.  **Configurar la Conexión a la Base de Datos:**
    * Edita el archivo de credenciales: `persistence/conf/credentials.json`.
    * Actualiza los valores de `database`, `username` y `password` para que coincidan con la configuración de tu MySQL local:

    ```json
    {
      "database": "[El nombre de la DB que creaste]",
      "username": "[Tu usuario de MySQL, ej: root]",
      "password": "[Tu contraseña de MySQL, ej: vacío o tu clave]",
      "host": "localhost"
    }
    ```

5.  **Acceder a la Aplicación:**
    * Asegúrate de que los servicios Apache y MySQL estén en ejecución.
    * Abre tu navegador y accede a la URL base de tu proyecto. (Ejemplo basado en un servidor local):

    ```
    http://localhost/DW-2DAM-ENTREGA-FUTBOL/
    ```

## 👨‍💻 Autor

Este proyecto ha sido desarrollado por:

* **Nombre Completo:** [Tu Nombre y Apellidos]
* **GitHub:** [@SrAlvarado](https://github.com/SrAlvarado)
* **Correo Electrónico:** [Tu correo electrónico]

## 📜 Licencia

Este proyecto se distribuye bajo la licencia **MIT**. Para más detalles, consulta el archivo [LICENSE] (si decides incluir uno).
