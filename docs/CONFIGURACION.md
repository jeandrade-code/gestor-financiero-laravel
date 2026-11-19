# Archivo de configuración

Documento de referencia con la configuración del proyecto **Gestor Financiero**. El archivo real es
`.env` (no se versiona); `.env.example` (sí se versiona) se entrega **idéntico** al `.env` de desarrollo
para que cualquier persona pueda consultar todos los valores.

---

## 1. Variables principales

| Variable | Valor en este proyecto | Propósito |
| -------- | ---------------------- | --------- |
| `APP_NAME` | `"Gestor Financiero"` | Nombre mostrado en la interfaz y en el título de las páginas |
| `APP_ENV` | `local` | Entorno de ejecución |
| `APP_KEY` | `base64:...` (incluida en `.env.example`) | Clave de cifrado; `key:generate` la reemplaza al instalar |
| `APP_DEBUG` | `true` | Muestra detalles de error en desarrollo |
| `APP_URL` | `http://localhost:8000` | URL base de la aplicación |
| `APP_LOCALE` | `es` | Idioma de la interfaz y de los mensajes de validación |
| `APP_FALLBACK_LOCALE` | `es` | Idioma de respaldo |
| `APP_FAKER_LOCALE` | `es_CO` | Locale de los datos falsos para las pruebas |

### Conexión a MySQL

| Variable | Valor |
| -------- | ----- |
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `127.0.0.1` |
| `DB_PORT` | `3306` |
| `DB_DATABASE` | `gestor_financiero` |
| `DB_USERNAME` | `root` |
| `DB_PASSWORD` | *(vacío en XAMPP por defecto)* |

### Otras variables relevantes

| Variable | Valor | Nota |
| -------- | ----- | ---- |
| `SESSION_DRIVER` | `database` | Las sesiones se guardan en la tabla `sessions` |
| `CACHE_STORE` | `database` | La caché usa la base de datos |
| `QUEUE_CONNECTION` | `database` | Cola de trabajos en base de datos |
| `MAIL_MAILER` | `log` | Los correos se escriben en el log, no se envían |
| `BCRYPT_ROUNDS` | `12` | Coste del hash de contraseñas |

---

## 2. Creación del archivo `.env`

El repositorio incluye `.env.example` con la configuración completa del entorno de desarrollo (es una copia
exacta del `.env` original). Para generar la configuración local:

```bash
copy .env.example .env
php artisan key:generate
```

`key:generate` sobrescribe la `APP_KEY` de ejemplo con una clave nueva. Después, ajustar `DB_PASSWORD` si el
usuario `root` de MySQL tiene contraseña.

---

## 3. Base de datos

```sql
CREATE DATABASE gestor_financiero
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

Luego:

```bash
php artisan migrate --seed
```

Esto crea las tablas `categorias`, `cuentas` y `transacciones` (más las tablas propias de Laravel:
`users`, `sessions`, `cache`, `jobs`, `password_reset_tokens`) y carga los datos de prueba.

### Restauración desde el respaldo SQL

```bash
mysql -u root -p gestor_financiero < database/sql/gestor_financiero.sql
```

---

## 4. Usuario de prueba

| Campo | Valor |
| ----- | ----- |
| Correo | `admin@gestorfinanciero.test` |
| Contraseña | `password` |

Se crea en `database/seeders/DatabaseSeeder.php`. También se pueden registrar usuarios nuevos desde la
pantalla **Registrarse**.

---

## 5. Compilación de los estilos

El proyecto usa **Vite** con **Tailwind CSS** (incluido por Laravel Breeze):

```bash
npm install
npm run build      # compila para producción en public/build
# o
npm run dev        # servidor de desarrollo con recarga en caliente
```

Si aparece el error *"Unable to locate file in Vite manifest"*, falta ejecutar `npm run build`.

---

## 6. Puesta en marcha

```bash
# Opción 1: servidor de desarrollo de Laravel
php artisan serve

# Opción 2: todos los procesos a la vez (servidor, cola, Vite)
composer run dev
```

Dirección resultante: `http://127.0.0.1:8000`.

---

## 7. Configuración regional (español)

El idioma se controla con `APP_LOCALE=es` y los textos viven en `lang/es/`:

| Archivo | Contenido |
| ------- | --------- |
| `lang/es/validation.php` | Mensajes de validación de todos los formularios |
| `lang/es/auth.php` | Mensajes de autenticación |
| `lang/es/passwords.php` | Recuperación de contraseña |
| `lang/es/pagination.php` | Paginación |

Los nombres legibles de los campos (por ejemplo `monto` → *monto*, `cuenta_id` → *cuenta*) se definen en
la clave `attributes` de `validation.php`, de modo que los errores se leen de forma natural.

---

## 8. Pruebas

Las pruebas usan SQLite en memoria y **no** afectan la base de datos de demostración. La configuración
está en `phpunit.xml`:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
<env name="SESSION_DRIVER" value="array"/>
```

Ejecución:

```bash
php artisan test --compact
```

---

## 9. Resumen de archivos de configuración del repositorio

| Archivo | Descripción |
| ------- | ----------- |
| `.env.example` | Plantilla de configuración (versionada) |
| `config/app.php` | Locale, zona horaria, nombre de la aplicación |
| `config/database.php` | Conexiones de base de datos |
| `phpunit.xml` | Configuración de las pruebas automatizadas |
| `vite.config.js` | Compilación de assets del frontend |
| `tailwind.config.js` | Configuración de Tailwind CSS |
| `database/sql/gestor_financiero.sql` | Respaldo de la base de datos con datos de prueba |