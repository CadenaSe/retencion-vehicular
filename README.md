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

![image](https://github.com/user-attachments/assets/7744679f-0438-4f81-9428-e2a780fbc4e9)


---

## Configuración

1. **Durante la instalación de XAMPP**  
   Asegúrate de seleccionar y activar los módulos **Apache** y **MySQL**.
![image](https://github.com/user-attachments/assets/ab9a2fcf-d6d6-47cf-a1d5-12fe4d1f5ec3)

2. **Copia el repositorio**  
   Copia este repositorio en la carpeta `htdocs` de tu instalación de XAMPP.  
  ![image](https://github.com/user-attachments/assets/2841a367-5cfa-469d-9424-ea265c158dd4)

3. **Inicia los servicios**  
- Abre el **Panel de Control de XAMPP**.
- Inicia los servicios **Apache** y **MySQL**.

4. **Accede al sistema**  
Abre tu navegador y ve a la siguiente URL:  
[http://localhost/sis-retencion/](http://localhost/sis-retencion/)

![image](https://github.com/user-attachments/assets/b1436db0-6780-42a0-ac19-fcb957efe347)


¡Y listo! Podrás usar el programa.

