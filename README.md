# Gestor Financiero

Aplicación web para registrar **cuentas, categorías y transacciones** (ingresos y gastos) y mantener el saldo
de cada cuenta actualizado automáticamente. Desarrollada con **Laravel 13 + MySQL + Laravel Breeze** para el
Taller Final de Programación III.

- **Repositorio:** https://github.com/jeandrade-code/gestor-financiero-laravel.git
- **Usuario de demostración:** `admin@gestorfinanciero.test` / `password`
- **Documentación completa:** [`docs/README.md`](docs/README.md)

---

## 1. Descargar el proyecto

```bash
git clone https://github.com/jeandrade-code/gestor-financiero-laravel.git
cd gestor-financiero-laravel
```

> Si no tiene Git instalado, también puede descargar el ZIP desde el enlace del repositorio y descomprimirlo.
> Todas las instrucciones siguientes se ejecutan **dentro de la carpeta del proyecto**.

## 2. Requisitos

| Herramienta | Versión verificada |
| ----------- | ------------------ |
| PHP | 8.4.13 |
| Composer | 2.8.12 |
| Laravel | 13.43.0 |
| MySQL / MariaDB | 10.4.32 (XAMPP) |
| Node.js | 24.20.0 |
| npm | 11.19.0 |

Extensiones PHP requeridas: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`, `xml`, `curl`.

En Windows con XAMPP: abrir `php.ini`, descomentar `extension=pdo_mysql`, `extension=mbstring` y
`extension=openssl`, guardar y reiniciar Apache.

## 3. Instalación completa

### Paso 1 — Dependencias de PHP

```bash
composer install
```

### Paso 2 — Archivo de entorno

```bash
copy .env.example .env        # Windows
cp .env.example .env          # macOS / Linux
php artisan key:generate
```

`.env.example` se entrega **idéntico al `.env` usado durante el desarrollo**, para que cualquier persona
(e incluido el docente) pueda ver la configuración completa: conexión MySQL, idioma, correo y demás
variables. `key:generate` sobrescribe `APP_KEY` con una clave nueva para su instalación; en un despliegue real
debe usarse siempre una clave propia.

### Paso 3 — Dependencias del frontend y compilación con Vite

Los estilos de Tailwind, Alpine.js y la gráfica SVG del panel se empaquetan con Vite:

```bash
npm install
npm run build
```

> Si la página sale sin estilos o aparece `Unable to locate file in Vite manifest`, ejecute `npm run build`.
> Para trabajar con recarga automática: `npm run dev`.

### Paso 4 — Base de datos

Crear la base de datos desde MySQL, phpMyAdmin o la consola:

```sql
CREATE DATABASE gestor_financiero
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
```

La conexión por defecto en `.env` es:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gestor_financiero
DB_USERNAME=root
DB_PASSWORD=
```

Ajuste `DB_USERNAME` y `DB_PASSWORD` si su MySQL tiene otra contraseña. Luego ejecutar:

```bash
php artisan migrate --seed
```

Esto crea las tablas y carga 1 usuario, 5 categorías, 3 cuentas y 5 transacciones.

**Alternativa:** importar el respaldo incluido, que contiene estructura, relaciones y datos:

```bash
mysql -u root -p gestor_financiero < database/sql/gestor_financiero.sql
```

> El respaldo también puede importarse desde phpMyAdmin: seleccionar la base `gestor_financiero` →
> **Importar** → elegir `database/sql/gestor_financiero.sql`.

### Paso 5 — Levantar la aplicación

```bash
php artisan serve
```

Abrir **http://127.0.0.1:8000**. Para usar otro puerto:

```bash
php artisan serve --host=127.0.0.1 --port=8123
```

También está disponible `composer run dev`, que inicia servidor, cola, Vite y el log en paralelo.

### Paso 6 — Ingresar

| Campo | Valor |
| ----- | ----- |
| Correo | `admin@gestorfinanciero.test` |
| Contraseña | `password` |

El usuario del seeder tiene el correo verificado, por lo que puede entrar directamente al panel y a los
tres módulos. Si crea un usuario nuevo desde **Crear una cuenta**, deberá verificar su correo antes de
acceder (los correos se escriben al log porque `MAIL_MAILER=log`).

## 4. Verificación rápida

```bash
php artisan test --compact
php artisan migrate:status
php artisan route:list --except-vendor
```

Resultado esperado: **47 pruebas y 132 aserciones correctas**, 6 migraciones ejecutadas y 37 rutas propias
(el resto pertenece a Laravel Breeze).

---

## 5. Módulos incluidos

| Módulo | Funcionalidad |
| ------ | ------------- |
| **Panel** | Saldo total, ingresos, gastos, balance neto, gráfica de líneas de los últimos seis meses y últimos seis movimientos. |
| **Categorías** | CRUD, filtro por texto y tipo, contador de movimientos. No se puede eliminar ni cambiar el tipo de una categoría en uso. |
| **Cuentas** | CRUD con saldo y moneda. El saldo se vuelve de solo lectura cuando la cuenta ya tiene movimientos; no se puede eliminar una cuenta con movimientos. |
| **Transacciones** | CRUD de ingresos/gastos, filtros por texto, tipo y cuenta. Los listados muestran nombres de cuenta y categoría, nunca IDs. |
| **Perfil** | Actualizar datos, cambiar contraseña y eliminar cuenta (Breeze). |

Todas las rutas de los módulos están protegidas por los middleware `auth` y `verified`.

### Reglas del saldo

La lógica está centralizada en `app/Services/GestorSaldo.php` y se ejecuta dentro de transacciones con
`lockForUpdate()`:

1. Un ingreso aumenta el saldo; un gasto lo disminuye.
2. El monto debe ser mayor que cero y la categoría debe coincidir con el tipo.
3. Un gasto no puede superar el saldo disponible.
4. Editar revierte el efecto anterior y aplica el nuevo, incluso al cambiar de cuenta o de tipo.
5. Eliminar revierte el efecto del movimiento.
6. Las llaves foráneas usan `restrictOnDelete()`, reforzado con validación en los controladores.

### Caso del taller

Partiendo de una cuenta con **$200.000**:

| Paso | Movimiento | Saldo |
| ---- | ---------- | ----- |
| 1 | Saldo inicial | **$200.000** |
| 2 | Ingreso de $150.000 | **$350.000** |
| 3 | Gasto de $20.000 | **$330.000** |

Después, al editar el ingreso a $100.000 el saldo queda en **$280.000**, y al eliminar el gasto de $20.000
queda en **$300.000**. Evidencia: [`docs/capturas/prueba-saldo/`](docs/capturas/prueba-saldo/).

## 6. Datos de prueba

- **Categorías (5):** Salario e Ventas (ingresos); Arriendo, Servicios públicos y Papelería (gastos).
- **Cuentas (3):** Caja ($330.000), Bancolombia ($1.650.000), Ahorros ($755.000).
- **Transacciones (5):** 2 ingresos y 3 gastos. El saldo de Caja reproduce el caso del taller.

## 7. Estructura del proyecto

```
app/
├── Http/Controllers/       Categoria, Cuenta, Transaccion, Dashboard, Landing
├── Http/Requests/          Validación de formularios (mensajes en español)
├── Models/                 Categoria, Cuenta, Transaccion, User
├── Services/GestorSaldo.php  Cálculo y reversión de saldos
└── View/Components/        Layouts, botones, tablas, estados vacíos, marca SVG
database/
├── migrations/             Esquema de las tres tablas del dominio
├── seeders/                Datos de prueba
├── factories/              Fábricas para las pruebas
└── sql/gestor_financiero.sql  Respaldo SQL entregable
docs/                       Guías, manual, arquitectura, diseño y capturas
resources/
├── css/app.css             Tokens y componentes Tailwind
├── js/charts.js            Gráfica SVG importada por Vite
└── views/                  Blade de autenticación, landing y módulos
routes/web.php              Rutas de la aplicación
tests/                      Pruebas feature y unit (SQLite en memoria)
```

## 8. Documentación y evidencias

| Documento | Contenido |
| --------- | --------- |
| [`docs/INSTALACION.md`](docs/INSTALACION.md) | Requisitos e instalación detallada |
| [`docs/CONFIGURACION.md`](docs/CONFIGURACION.md) | Variables de entorno y compilación de assets |
| [`docs/BASE_DATOS.md`](docs/BASE_DATOS.md) | Esquema, relaciones, datos y respaldo SQL |
| [`docs/ARQUITECTURA.md`](docs/ARQUITECTURA.md) | Capas, rutas y flujo de una petición |
| [`docs/MANUAL_USUARIO.md`](docs/MANUAL_USUARIO.md) | Uso de los tres módulos y del panel |
| [`docs/PRUEBAS.md`](docs/PRUEBAS.md) | Pruebas automatizadas y verificación en navegador |
| [`docs/SUSTENTACION.md`](docs/SUSTENTACION.md) | Guion de sustentación en parejas |
| [`docs/DISENO.md`](docs/DISENO.md) | Sistema visual, responsive y accesibilidad |

Capturas:

- [`docs/capturas/diseno/`](docs/capturas/diseno/) — desktop, móvil, modo oscuro, menú minimizado y gráfica.
- [`docs/capturas/prueba-saldo/`](docs/capturas/prueba-saldo/) — secuencia completa de cambio de saldo.
- [`docs/capturas/resumen.json`](docs/capturas/resumen.json) — resumen de la verificación.

## 9. Solución de problemas

| Síntoma | Solución |
| ------- | -------- |
| `SQLSTATE[HY000] [1045] Access denied` | Revisar `DB_USERNAME` / `DB_PASSWORD` en `.env` |
| `No such file or directory` al conectar | Verificar que MySQL esté activo y usar `DB_HOST=127.0.0.1` |
| Error 500 apenas clonar | Ejecutar `php artisan key:generate` |
| Página sin estilos | Ejecutar `npm install && npm run build` |
| Redirección a `/verify-email` | Usar el usuario demo o verificar el correo registrado |
| Cambios de Blade sin reflejarse | `php artisan view:clear` |

---

**Nota:** los directorios `vendor/`, `node_modules/` y `public/build/` no se versionan. Por eso es obligatorio
ejecutar `composer install`, `npm install` y `npm run build` después de descargar el proyecto.
