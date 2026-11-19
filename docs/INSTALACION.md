# Instalación

## 1. Requisitos

| Herramienta | Versión verificada |
| ----------- | ------------------ |
| PHP | 8.4.13 |
| Composer | 2.8.12 |
| Laravel | 13.43.0 |
| MySQL / MariaDB | 10.4.32 (XAMPP) |
| Node.js | 24.20.0 |
| npm | 11.19.0 |

Extensiones PHP requeridas: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`, `xml` y `curl`.

> En Windows con XAMPP, habilitar `pdo_mysql`, `mbstring` y `openssl` desde `php.ini` y reiniciar Apache.

## 2. Obtener el código e instalar dependencias

```bash
cd gestor-financiero
composer install
copy .env.example .env
php artisan key:generate
```

`key:generate` es obligatorio: sin `APP_KEY` las sesiones y las cookies cifradas fallan con un error 500.

## 3. Frontend

Los estilos (Tailwind) y el JavaScript (Alpine + gráfica SVG) se compilan con Vite:

```bash
npm install
npm run build
```

Para desarrollo con recarga automática:

```bash
npm run dev
```

Si aparece `Unable to locate file in Vite manifest`, ejecutar `npm run build`.

## 4. Base de datos

Crear la base de datos desde MySQL, phpMyAdmin o la consola:

```sql
CREATE DATABASE gestor_financiero
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Ajustar `DB_USERNAME` y `DB_PASSWORD` en `.env` y ejecutar:

```bash
php artisan migrate --seed
```

Esto crea todas las tablas y carga: 1 usuario, 5 categorías, 3 cuentas y 5 transacciones.

### Alternativa: restaurar el respaldo SQL

El archivo `database/sql/gestor_financiero.sql` incluye estructura, relaciones y datos. Está en UTF-8 sin BOM
y contiene un único usuario de demostración.

```bash
mysql -u root -p < database/sql/gestor_financiero.sql
```

También se puede importar desde phpMyAdmin seleccionando la base `gestor_financiero`.

## 5. Levantar la aplicación

```bash
php artisan serve
```

Abrir `http://127.0.0.1:8000`. Si se usa otro puerto:

```bash
php artisan serve --host=127.0.0.1 --port=8123
```

También está disponible `composer run dev`, que inicia servidor, cola y Vite en paralelo.

## 6. primer ingreso

| Campo | Valor |
| ----- | ----- |
| Correo | `admin@gestorfinanciero.test` |
| Contraseña | `password` |

El usuario del seeder tiene el correo verificado, por lo que puede entrar directamente a los módulos
protegidos por `auth` y `verified`.

## 7. Verificación de la instalación

```bash
php artisan migrate:status
php artisan route:list --except-vendor
php artisan test --compact
```

Se esperan 6 migraciones ejecutadas, 37 rutas propias (el resto son de Laravel Breeze) y 47 pruebas correctas.

## 8. Problemas frecuentes

| Síntoma | Solución |
| ------- | -------- |
| `SQLSTATE[HY000] [1045] Access denied` | Revisar `DB_USERNAME` / `DB_PASSWORD` en `.env` |
| `No such file or directory` al conectar | Verificar que MySQL esté corriendo y que el host sea `127.0.0.1` |
| Página sin estilos | Ejecutar `npm run build` |
| Error 500 después de clonar | Ejecutar `php artisan key:generate` |
| Redirección a `/verify-email` | Usar el usuario del seeder o verificar el correo del usuario registrado |
| Cambios de Blade sin reflejarse | `php artisan view:clear` |
