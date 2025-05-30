# Importación de Ciudades y Ciudadanos

Este repositorio contiene una aplicación Laravel para la gestión e importación de datos de ciudades y ciudadanos mediante archivos Excel (.xlsx) y CSV (.csv).

Los detalles se encuentran en el documento "Importación de Ciudades y Ciudadanos" ubicado en `resources/docs/Importación de Ciudades y Ciudadanos.pdf`.

## Requisitos
- PHP >= 8.1
- Composer
- Laravel 12.x
- Extensión PHP para manejo de archivos y Excel (Maatwebsite/Laravel-Excel)

## Instalación

1. Clona el repositorio:
   ```bash
   git clone <url-del-repositorio>
   cd registropersona
   ```

2. Instala las dependencias de PHP:
   ```bash
   composer install
   ```

3. Instala las dependencias de Node.js:
   ```bash
   npm install
   ```

4. Copia el archivo de entorno y configura tus variables:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configura la base de datos en el archivo `.env`.

6. Ejecuta las migraciones:
   ```bash
   php artisan migrate
   ```

7. Compila los assets:
   ```bash
   npm run build
   ```

8. Inicia el servidor de desarrollo:
   ```bash
   php artisan serve
   ```

## Importación de Ciudades y Ciudadanos

Para importar ciudadanos o ciudades:

1. Accede a la sección correspondiente en la aplicación.
2. Selecciona el archivo Excel (.xlsx) o CSV (.csv) con los datos a importar.
3. Haz clic en "Importar".

El sistema validará y procesará el archivo, mostrando mensajes de éxito o error según corresponda.

## Estructura de Archivos de Importación

- El archivo debe contener las columnas requeridas para cada entidad (ver documentación interna o ejemplo de archivo).
- Asegúrate de que los datos estén correctamente formateados antes de importar.

## Créditos
- Basado en Laravel 12.x
- Utiliza [Maatwebsite/Laravel-Excel](https://laravel-excel.com/)

---


