# Suplos API

El proyecto es una API REST desarrollada en PHP y MySql.
<img src="https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-plain.svg" height="40" alt="php logo"  /> <img src="https://cdn.simpleicons.org/mysql/4479A1" height="40" alt="mysql logo"  />
## Requisitos del Entorno Local

Para ejecutar este proyecto en tu entorno local, necesitas tener instalado lo siguiente:

1. **XAMPP**: Un entorno de desarrollo que incluye Apache y MySQL. Puedes descargarlo [aquí](https://www.apachefriends.org/index.html).

2. dirigete a la al archivo ```C:\xampp\apache\conf\extra\httpd-vhosts.conf``` y agrega lo siguiente:
```apache
<VirtualHost *:80>
    DocumentRoot "C:/xampp/htdocs/suplos-api"
    ServerName suplos.api.com
</VirtualHost>
```
3. dirigite al archivo ```C:\Windows\System32\drivers\etc\hosts``` y agrega: ```
127.0.0.1 suplos.api.com ```


## Configuración del Entorno Local

Sigue estos pasos para configurar tu entorno local:

1. Instala XAMPP siguiendo las instrucciones en su sitio web.

2. Inicia XAMPP y asegúrate de que Apache y MySQL estén funcionando.

3. Descarga este proyecto y colócalo en la carpeta `htdocs` de tu instalación de XAMPP. Por lo general, esta carpeta se encuentra en la siguiente ubicación (dependiendo de tu sistema operativo):
   - **Windows**: `C:\xampp\htdocs`
   - **Linux**: `/opt/lampp/htdocs`
   - **macOS**: `/Applications/XAMPP/xamppfiles/htdocs`

4. en la carpeta db encontraras el archivo suplos.sql ejecutalo para crear la base de datos.

despues de haber creado la db ya el back estara listo.