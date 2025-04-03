# Users Management App

Este proyecto es una aplicación desarrollada con Laravel Breeze, Vue.js e Inertia.js. Su propósito principal es gestionar usuarios, proporcionando una interfaz moderna y eficiente para realizar operaciones CRUD (Crear, Leer, Actualizar y Eliminar) sobre la entidad `Users`.

![VIsta principal](public\images\readme\example_1.jpeg)

## Características principales

- **Gestión de usuarios**: La aplicación permite crear, visualizar, editar y eliminar usuarios. Así como exportar los registros en un archivo CSV.
- **Interfaz dinámica**: Utiliza Vue.js e Inertia.js para ofrecer una experiencia de usuario fluida y dinámica.
- **Autenticación**: Laravel Breeze proporciona un sistema de autenticación básico, incluyendo registro, inicio de sesión y recuperación de contraseñas.
- **Vistas personalizadas**: Las vistas relacionadas con la gestión de usuarios se encuentran en la carpeta `resources/js/Pages/Users` y se utilizan componentes de `resources/js/Components`.

## Estructura del proyecto

### Entidad `Users`
La entidad `Users` representa a los usuarios de la aplicación. Incluye atributos como nombre, correo electrónico, contraseña, teléfono y cualquier otro campo relevante para la gestión de usuarios.
Esta entidad utiliza SoftDeletes para conservar la información de cada usuario registrado.

### Tablas de Spatie Laravel/Permission
1. **`permissions`**:
   - Contiene los permisos disponibles en la aplicación.
   - Campos principales:
     - `id`: Identificador único.
     - `name`: Nombre del permiso (ej., `create_users`, `edit_users`).
     - `guard_name`: Nombre del guard (ej., `web`).
     - `created_at` y `updated_at`: Timestamps.

2. **`roles`**:
   - Contiene los roles que agrupan permisos.
   - Campos principales:
     - `id`: Identificador único.
     - `name`: Nombre del rol (ej., `admin`, `user`).
     - `guard_name`: Nombre del guard.
     - `created_at` y `updated_at`: Timestamps.

3. **`model_has_permissions`**:
   - Relaciona modelos (como `User`) con permisos específicos.
   - Campos principales:
     - `permission_id`: ID del permiso.
     - `model_type`: Tipo de modelo (ej., `App\Models\User`).
     - `model_id`: ID del modelo relacionado.

4. **`model_has_roles`**:
   - Relaciona modelos (como `User`) con roles específicos.
   - Campos principales:
     - `role_id`: ID del rol.
     - `model_type`: Tipo de modelo (ej., `App\Models\User`).
     - `model_id`: ID del modelo relacionado.

5. **`role_has_permissions`**:
   - Relaciona roles con permisos.
   - Campos principales:
     - `permission_id`: ID del permiso.
     - `role_id`: ID del rol.

- La entidad `User` se relaciona con estas tablas a través de los modelos de Laravel y el paquete.
- De forma que un usuario (`User`) puede:
  - Tener **roles** asignados mediante la tabla `model_has_roles`.
  - Tener **permisos** asignados directamente mediante la tabla `model_has_permissions`.
  - Obtener permisos indirectamente a través de los roles asignados, definidos en la tabla `role_has_permissions`.


### Controlador `UsersController`
El controlador [`UsersController`](app/Http/Controllers/UsersController.php) maneja la lógica de negocio relacionada con los usuarios. Este incluye métodos para:
- Listar usuarios.
- Crear nuevos usuarios.
- Actualizar información de usuarios existentes.
- Eliminar usuarios.

### Vistas de la carpeta `Users`
Las vistas relacionadas con la gestión de usuarios están ubicadas en `resources/js/Pages/Users`. Estas vistas incluyen:
- **Index.vue**: Muestra la lista de usuarios y da acceso a las funciones de editar, agregar y eliminar.
- **UsersModal.vue**: Formulario para crear un nuevo usuario o editar uno existente.
    - En el formulario de crear usuario los campos de Nombre, Email y Contraseña son obligatorios.
    - Para el formulario de Editar Usuario; Contraseña no es obligatoria. 
- **Pagination.vue**: Componente que permite la paginación de los registros en `Index.vue`.

### Paquetes requeridos
- **spatie/laravel-permission**: Encargado de la creación de las tablas para permisos y roles.
- **laravel-lang**: Ofrece paquetes de traducción para distintos idiomas.
- **fontawesome**: Permite el uso de iconos dentro de la aplicación
- **bootstrap**: Conjunto de métodos css y js que permiten una personalización rápida para etiquetas y componentes.
- **sweetalert2**: Conjunto de métodos js que permiten mostrar mensajes y alertas en el navegador.
- **maatwebsite/excel**: Paquete que implementa métodos para agilizar el proceso de importación y exportación de archivos csv y xlsx

## Requisitos del sistema
- PHP 8.x
- Composer
- Node.js y npm
- Base de datos compatible con Laravel (PostgreSQL)

## Instalación
1. Clona este repositorio.
    ```bash
    git clone https://github.com/LAXELmve/Users_Managment-App.git
    cd users_managment-app
2. Instala las dependencias de PHP:
   ```bash
   composer install

3. Instala las dependencias de JavaScript:
    ```bash
    npm install

4. Configura el archivo .env con tus credenciales de base de datos. Puede apoyarse del archivo `.env.example`.
    ```bash
    cp .env.example .env

Ejecutar el siguiente comando para generar la clave de la aplicación:
    
    php artisan key:generate

5. Ejecuta las migraciones:
    ```bash
    php artisan migrate

6. Ejecuta los Seeders:
    ```bash
    php artisan db:seed

Dentro de estos archivos se encuentran los roles necesarios para la correcta ejecución de la app y se incluyen 15 usuarios mediante Factory.

7. Inicia el servidor de desarrollo:
    ```bash
    npm run dev
    php artisan serve
