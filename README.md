# SOS La Azohía

Aplicación web para la asociación **SOS La Azohía**, dedicada a la protección del litoral de la Región de Murcia. Proyecto de fin de ciclo del Técnico Superior en Desarrollo de Aplicaciones Web (CESUR, 2026).

Los visitantes pueden informarse de las noticias de la asociación y colaborar con donaciones a través de una tienda solidaria. La asociación gestiona el contenido de forma autónoma desde un panel de administración.

## Funcionalidades

- **Noticias:** listado público y gestión desde administración (crear, modificar y eliminar).
- **Tienda solidaria:** catálogo de productos con gestión desde administración (crear, modificar y eliminar).
- **Carrito de donaciones:** añadir y quitar productos y vaciar el carrito. Es un proyecto académico: no se procesan pagos reales.
- **Página "Quiénes somos"** editable desde administración.
- **Panel de administración** con login para gestionar noticias, productos e información de la asociación.
- **Diseño responsive** con Bootstrap.

## Tecnologías

PHP (PDO) · MySQL · Bootstrap · HTML/CSS · JavaScript

## Estructura

```
├── index.php, tienda.php, donacion.php, quienes_somos.php   # páginas públicas
├── login.php, administracion*.php, editar_informacion.php   # panel de administración
├── nueva_/modificar_/eliminar_noticia.php                   # gestión de noticias
├── nuevo_/modificar_/eliminar_producto.php                  # gestión de productos
├── añadir_donacion.php, eliminar_donacion_item.php,
│   vaciar_donacion.php                                      # carrito de donaciones
├── conexion.php, funciones.php                              # conexión a la base de datos y utilidades
├── insert_info.sql, insert_noticias.sql                     # datos iniciales
├── css/
└── uploads/                                                 # imágenes y vídeo
```

## Cómo ejecutarlo en local

1. Instala un entorno con PHP y MySQL (por ejemplo XAMPP) y arranca Apache y MySQL.
2. Copia el proyecto en la carpeta del servidor (`htdocs` en XAMPP).
3. Crea en MySQL una base de datos vacía llamada `proyecto2025` con codificación `utf8mb4`.
4. Copia `admin.config.example.php` como `admin.config.php` y escribe en él el nombre, el correo y una contraseña propia para el administrador (este archivo no se sube a GitHub).
5. Abre `http://localhost/<carpeta-del-proyecto>/` en el navegador. Al cargar, `conexion.php` crea automáticamente las tablas (`users`, `noticias`, `productos` e `informacion`) y el usuario administrador a partir de `admin.config.php`.
6. Opcional: importa `insert_info.sql` e `insert_noticias.sql` para cargar contenido de ejemplo.

La conexión usa los valores por defecto de XAMPP. Si tu MySQL es distinto, cámbialos en `conexion.php`.

## Capturas

[Añade aquí 2 o 3 capturas: la portada, la tienda y el panel de administración.]

## Autoría

Ángela Vega Sánchez y Natividad Alarcos.

[LinkedIn](https://www.linkedin.com/in/angela-vega-sanchez/) · [Portfolio](https://angelas482511.github.io/porfolio/)
