# Instalación
```
componser install
npm install
```
### Conexión base de datos
crear un .env y modifcar
```
DB_CONNECTION=<driver>
DB_PORT=<Puerto>
DB_DATABASE=<Nombre de la base de datos>
DB_USERNAME=<usuario>
DB_PASSWORD=<contraseña>
```
despues crear tablas y migrar datos
```
php artisan key:generate
php artisan migrate:fresh --seed
php artisan passport:install
```
# Configuracion de permisos

Se cambian los permisos de la carpeta "storage" y "bootstrap/cache".
´´´
sudo chgrp -R www-data storage bootstrap/cache
sudo chmod -R ug+rwx storage bootstrap/cache
´´´

Se cambian los permisos de la carpeta "public".
´´´
sudo chmod -R ugo+rw public
´´´

# Usar aplicación

## Para desarrollo
```
npm run dev
```
## Para producción
```
npm run prod
```