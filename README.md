# Gestor Financiero

Aplicación web desarrollada en **Laravel 13** para el Taller Final de Programación III. Permite administrar
cuentas de efectivo y bancos, fuentes de ingreso, gastos y el saldo de cada cuenta, con acceso mediante
usuario y contraseña.

---

## 1. Requisitos

| Herramienta | Versión usada |
| ----------- | ------------- |
| PHP         | 8.4.13        |
| Composer    | 2.8.12        |
| Laravel     | 13.43.0       |
| MySQL / MariaDB | 10.4.32 (XAMPP) |
| Node.js     | 24.20.0       |
| npm         | 11.19.0       |

Extensiones de PHP necesarias: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`, `xml`, `curl`.

---

## 2. Instalación paso a paso

```bash
# 1. Dependencias de PHP
composer install

# 2. Archivo de configuración
copy .env.example .env
php artisan key:generate

# 3. Dependencias del frontend y compilación de estilos
npm install
npm run build

# 4. Crear la base de datos en MySQL
#    (desde la consola de MySQL o phpMyAdmin)
CREATE DATABASE gestor_financiero CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 5. Crear las tablas y cargar los datos de prueba
php artisan migrate --seed

# 6. Levantar el servidor
php artisan serve
```

La aplicación queda disponible en `http://127.0.0.1:8000`.

### Restauración desde el archivo SQL

Si se prefiere partir del respaldo incluido (estructura + relaciones + datos de prueba):

```bash
mysql -u root -p gestor_financiero < database/sql/gestor_financiero.sql
```

---

## 3. Credenciales de prueba

| Campo      | Valor                          |
| ---------- | ------------------------------ |
| Correo     | `admin@gestorfinanciero.test`  |
| Contraseña | `password`                     |

El usuario se crea automáticamente al ejecutar `php artisan migrate --seed`. También es posible registrar
usuarios nuevos desde la pantalla **Registrarse**.

---

## 4. Estructura de la base de datos

Base de datos: **`gestor_financiero`** (MySQL, `utf8mb4` / `utf8mb4_unicode_ci`).

### `categorias`

| Columna      | Tipo                              | Restricciones              |
| ------------ | --------------------------------- | -------------------------- |
| `id`         | BIGINT UNSIGNED                   | PK, AUTO_INCREMENT         |
| `nombre`     | VARCHAR(150)                      | NOT NULL                   |
| `tipo`       | ENUM('ingreso','gasto')           | NOT NULL                   |
| `descripcion`| VARCHAR(255)                      | NULL                       |
| `created_at` | TIMESTAMP                         | NULL                       |
| `updated_at` | TIMESTAMP                         | NULL                       |

### `cuentas`

| Columna      | Tipo            | Restricciones                    |
| ------------ | --------------- | -------------------------------- |
| `id`         | BIGINT UNSIGNED | PK, AUTO_INCREMENT               |
| `nombre`     | VARCHAR(150)    | NOT NULL                         |
| `descripcion`| VARCHAR(255)    | NULL                             |
| `saldo`      | DECIMAL(18,2)   | NOT NULL, DEFAULT 0.00           |
| `moneda`     | VARCHAR(10)     | DEFAULT 'COP'                    |
| `created_at` | TIMESTAMP       | NULL                             |
| `updated_at` | TIMESTAMP       | NULL                             |

### `transacciones`

| Columna        | Tipo                    | Restricciones                          |
| -------------- | ----------------------- | -------------------------------------- |
| `id`           | BIGINT UNSIGNED         | PK, AUTO_INCREMENT                     |
| `cuenta_id`    | BIGINT UNSIGNED         | NOT NULL, FK → `cuentas.id`            |
| `categoria_id` | BIGINT UNSIGNED         | NOT NULL, FK → `categorias.id`         |
| `tipo`         | ENUM('ingreso','gasto') | NOT NULL                               |
| `monto`        | DECIMAL(18,2)           | NOT NULL                               |
| `fecha`        | DATE                    | NOT NULL                               |
| `descripcion`  | VARCHAR(255)            | NULL                                   |
| `creado_por`   | VARCHAR(150)            | NULL (usuario que registró el movimiento) |
| `created_at`   | TIMESTAMP               | NULL                                   |
| `updated_at`   | TIMESTAMP               | NULL                                   |

### Relaciones Eloquent

```php
Cuenta::transacciones()      // hasMany
Categoria::transacciones()   // hasMany
Transaccion::cuenta()        // belongsTo
Transaccion::categoria()     // belongsTo
```

**Integridad referencial:** las llaves foráneas se crean con `restrictOnDelete()`, de modo que MySQL
rechaza el borrado de una cuenta o categoría que tenga movimientos asociados. Además, la aplicación
valida la condición antes de ejecutar el `DELETE` y muestra un mensaje de error al usuario.

---

## 5. Módulos

### Autenticación (Laravel Breeze – Blade + Tailwind)

Registro, inicio de sesión, cierre de sesión, recuperación de contraseña, verificación de correo y
gestión del perfil. **Todos los módulos exigen autenticación**: cualquier visita a `/categorias`,
`/cuentas`, `/transacciones` o `/dashboard` sin sesión redirige a `/login`.

### Categorías

CRUD completo con `nombre`, `tipo` (ingreso/gasto) y `descripcion`. El listado muestra cuántas
transacciones usan cada categoría. No se permite eliminar una categoría con movimientos, ni cambiar su
`tipo` cuando ya está en uso (evita incoherencias entre la categoría y el tipo de los movimientos).

### Cuentas

CRUD completo con `nombre`, `descripcion`, `saldo` y `moneda`. El listado muestra el saldo actual de cada
cuenta. No se permite eliminar una cuenta con movimientos asociados. Cuando la cuenta ya tiene
movimientos, el campo `saldo` se muestra de solo lectura porque lo calcula el sistema.

### Transacciones

CRUD completo de ingresos y gastos con `cuenta`, `categoría`, `tipo`, `monto`, `fecha`, `descripcion` y el
usuario que registra el movimiento (`creado_por`). El listado muestra el **nombre** de la cuenta y de la
categoría (no los identificadores), permite filtrar por tipo y por cuenta, y ordena por fecha descendente.

### Panel general

Resumen con el saldo total de todas las cuentas, el total de ingresos, el total de gastos y los últimos
cinco movimientos.

---

## 6. Reglas de negocio del saldo

Toda la lógica vive en `app/Services/GestorSaldo.php` y se ejecuta dentro de una transacción de base de
datos con `lockForUpdate()` para evitar condiciones de carrera.

1. **Ingreso** → el saldo de la cuenta **aumenta** en el monto.
2. **Gasto** → el saldo de la cuenta **disminuye** en el monto.
3. **Edición** → primero se revierte el efecto anterior y luego se aplica el nuevo, incluso si cambia la
   cuenta o el tipo del movimiento.
4. **Eliminación** → se revierte el efecto en el saldo.
5. Se rechazan montos **menores o iguales a cero**.
6. Una categoría de tipo `ingreso` solo se acepta en movimientos de ingreso, y una de tipo `gasto` solo en
   gastos.
7. Un **gasto no puede superar el saldo disponible** de la cuenta.

### Escenario de verificación del taller

Cuenta con saldo inicial de **$200.000**:

| Paso | Movimiento              | Saldo resultante |
| ---- | ----------------------- | ---------------- |
| 1    | Saldo inicial           | **$200.000**     |
| 2    | Ingreso de $150.000     | **$350.000**     |
| 3    | Gasto de $20.000        | **$330.000**     |

El resultado final es **$330.000**, tal como exige el taller. Las capturas de este escenario están en
`docs/capturas/13-prueba-saldo-inicial-200000.png` a `19-prueba-saldo-tras-eliminar-300000.png`, e incluyen
la comprobación del efecto de **editar** y **eliminar** un movimiento sobre el saldo.

---

## 7. Pruebas automatizadas

```bash
php artisan test --compact
```

Resultado actual: **46 pruebas aprobadas, 130 aserciones**.

| Archivo | Cobertura |
| ------- | --------- |
| `tests/Feature/SaldoTest.php` | Aumento, disminución, escenario del taller ($330.000), reversión al editar, cambio de tipo, traslado entre cuentas, reversión al eliminar, rechazo de monto 0 y de gasto sin saldo suficiente. |
| `tests/Feature/EliminacionProtegidaTest.php` | Bloqueo de borrado de cuentas y categorías con movimientos, borrado permitido sin movimientos, y redirección a `login` sin sesión. |
| `tests/Feature/TransaccionCrudTest.php` | Registro y actualización con efecto en saldo, autor del movimiento, rechazo de categoría incoherente, nombres en el listado, bloqueo de edición manual del saldo y del cambio de tipo de categoría en uso. |
| `tests/Feature/VistasTest.php` | Las diez vistas autenticadas responden 200 y el formulario conserva los datos tras un error de validación. |

Las pruebas se ejecutan sobre SQLite en memoria (ver `phpunit.xml`), por lo que **no alteran** los datos de
demostración en MySQL.

---

## 8. Capturas de pantalla

Todas las imágenes están en `docs/capturas/` y se generaron contra la aplicación en ejecución:

| Archivo | Contenido |
| ------- | --------- |
| `01-login.png` | Pantalla de inicio de sesión |
| `02-dashboard.png` | Panel general |
| `03-categorias.png` | Listado de categorías |
| `04-cuentas.png` | Listado de cuentas con saldo actual |
| `05-transacciones.png` | Listado de transacciones con nombres de cuenta y categoría |
| `06`–`11` | Formularios de creación y edición de los tres módulos |
| `12-validacion-monto-negativo.png` | Validación de monto, con los datos del formulario conservados |
| `12b-validacion-saldo-insuficiente.png` | Validación de gasto superior al saldo disponible |
| `13`–`19` | Prueba de cambio de saldo: inicial $200.000, ingreso $150.000, gasto $20.000, edición y eliminación |
| `21`–`22` | Bloqueo de eliminación de una cuenta y de una categoría con movimientos |
| `24-tras-logout.png` | Redirección al inicio de sesión tras cerrar sesión |

El archivo `docs/capturas/resumen.json` contiene el texto y los valores capturados en cada paso.

---

## 9. Estructura del proyecto

```
app/
├── Http/
│   ├── Controllers/     CategoriaController, CuentaController, TransaccionController, DashboardController
│   └── Requests/        Validación de los tres módulos
├── Models/              Categoria, Cuenta, Transaccion
└── Services/            GestorSaldo (motor de cálculo del saldo)
database/
├── migrations/          Estructura de las tres tablas
├── seeders/             Datos de prueba
├── factories/           Fábricas para las pruebas
└── sql/                 Respaldo SQL con estructura, relaciones y datos
docs/capturas/           Evidencias del funcionamiento
lang/es/                 Traducciones al español (validación, autenticación, paginación)
resources/views/         Vistas Blade de los tres módulos y del panel
routes/web.php           Rutas de la aplicación
```

---

## 10. Datos de prueba cargados

**Categorías (5):** Salario (ingreso), Ventas (ingreso), Arriendo (gasto), Servicios públicos (gasto),
Papelería (gasto).

**Cuentas (3):** Caja ($330.000), Bancolombia ($1.650.000), Ahorros ($755.000).

**Transacciones (5):** dos ingresos ($150.000 y $450.000) y tres gastos ($20.000, $300.000 y $45.000).

El saldo de **Caja** es la comprobación del taller: 200.000 + 150.000 − 20.000 = **330.000**.

---

## 11. Notas para la defensa

- El saldo **no** se edita a mano: es el resultado de los movimientos. Por eso, una cuenta con
  transacciones muestra el campo `saldo` bloqueado y una categoría en uso no permite cambiar su `tipo`.
- Los dos bloqueos de integridad están aplicados en **dos capas**: la llave foránea con
  `restrictOnDelete()` en MySQL y la validación en el controlador con mensaje al usuario.
- El motor de saldo es el único punto que modifica `cuentas.saldo`; ningún controlador lo actualiza
  directamente.
- La interfaz está completamente en español, incluidos los mensajes de validación (`lang/es`).