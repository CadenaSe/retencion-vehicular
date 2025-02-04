# Sistema de Retención Vehicular

Bienvenido al repositorio del **Sistema de Retención Vehicular**. A continuación, se detallan los pasos para configurar y ejecutar el proyecto en tu entorno local.

---

## Requisitos

Para ejecutar este proyecto, necesitarás lo siguiente:

- **XAMPP**: Descarga e instala [XAMPP](https://www.apachefriends.org/index.html) en tu sistema.
- Un navegador web moderno (Google Chrome, Firefox, etc.).

---

## Importar la Base de Datos

1. **Descarga el archivo SQL**  
   Descarga el archivo `database/sis_recaudacion.sql` desde este repositorio.

2. **Crea la base de datos**  
   - Abre **phpMyAdmin** (accede a `http://localhost/phpmyadmin` después de iniciar XAMPP).
   - Crea una nueva base de datos con el nombre **sis_retencion_vehicular**.

3. **Importa el archivo SQL**  
   - Ve a la pestaña **Importar** en phpMyAdmin.
   - Sube el archivo `sis_recaudacion.sql`.
   - Haz clic en **Ejecutar** para completar la importación.



---

## Configuración

1. **Durante la instalación de XAMPP**  
   Asegúrate de seleccionar y activar los módulos **Apache** y **MySQL**.

2. **Copia el repositorio**  
   Copia este repositorio en la carpeta `htdocs` de tu instalación de XAMPP.  
  
