# Base de datos

Motor: **MySQL / MariaDB 10.4+**, charset `utf8mb4`, collation `utf8mb4_unicode_ci`.
Nombre de la base: `gestor_financiero`.

## 1. Tablas del dominio

### `categorias`

| Columna | Tipo | Restricción |
| ------- | ---- | ----------- |
| `id` | `bigint unsigned` | PK, autoincremental |
| `nombre` | `varchar(150)` | obligatorio |
| `tipo` | `enum('ingreso','gasto')` | obligatorio |
| `descripcion` | `varchar(255)` | opcional |
| `created_at` / `updated_at` | `timestamp` | nullable |

### `cuentas`

| Columna | Tipo | Restricción |
| ------- | ---- | ----------- |
| `id` | `bigint unsigned` | PK, autoincremental |
| `nombre` | `varchar(150)` | obligatorio |
| `descripcion` | `varchar(255)` | opcional |
| `saldo` | `decimal(18,2)` | obligatorio, default `0.00` |
| `moneda` | `varchar(10)` | obligatorio, default `COP` |
| `created_at` / `updated_at` | `timestamp` | nullable |

### `transacciones`

| Columna | Tipo | Restricción |
| ------- | ---- | ----------- |
| `id` | `bigint unsigned` | PK, autoincremental |
| `cuenta_id` | `bigint unsigned` | FK → `cuentas.id`, `RESTRICT` |
| `categoria_id` | `bigint unsigned` | FK → `categorias.id`, `RESTRICT` |
| `tipo` | `enum('ingreso','gasto')` | obligatorio |
| `monto` | `decimal(18,2)` | obligatorio, mayor que cero |
| `fecha` | `date` | obligatoria |
| `descripcion` | `varchar(255)` | opcional |
| `creado_por` | `varchar(150)` | opcional, usuario que registró el movimiento |
| `created_at` / `updated_at` | `timestamp` | nullable |

 Las llaves foráneas se declaran con `restrictOnDelete()`, por lo que la base de datos impide borrar una
cuenta o categoría que todavía tenga movimientos. Los controladores también validan el caso y muestran
un mensaje en español.

Tablas auxiliares de Laravel: `users`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`,
`failed_jobs`, `password_reset_tokens`, `password_resets` según la instalación.

## 2. Datos de prueba

### Categorías (5)

| ID | Nombre | Tipo |
| -- | ------ | ---- |
| 1 | Salario | ingreso |
| 2 | Ventas | ingreso |
| 3 | Arriendo | gasto |
| 4 | Servicios públicos | gasto |
| 5 | Papelería | gasto |

### Cuentas (3)

| ID | Nombre | Saldo inicial cargado |
| -- | ------ | --------------------- |
| 1 | Caja | $330.000,00 |
| 2 | Bancolombia | $1.650.000,00 |
| 3 | Ahorros | $755.000,00 |

### Transacciones (5)

| ID | Cuenta | Categoría | Tipo | Monto | Fecha |
| -- | ------ | --------- | ---- | ----- | ----- |
| 1 | Caja | Salario | ingreso | $150.000,00 | 2026-11-09 |
| 2 | Caja | Servicios públicos | gasto | $20.000,00 | 2026-11-14 |
| 3 | Bancolombia | Ventas | ingreso | $450.000,00 | 2026-11-11 |
| 4 | Bancolombia | Arriendo | gasto | $300.000,00 | 2026-11-16 |
| 5 | Ahorros | Papelería | gasto | $45.000,00 | 2026-11-18 |

El saldo de **Caja** reproduce el caso del taller:

```
$200.000 (saldo inicial) + $150.000 (ingreso) − $20.000 (gasto) = $330.000
```

### Usuario de demostración

`admin@gestorfinanciero.test` / `password` (correo verificado).

## 3. Respaldo entregable

Archivo: `database/sql/gestor_financiero.sql`.

Contenido:

- `CREATE DATABASE` y `USE gestor_financiero`.
- Estructura de todas las tablas.
- Llaves primarias, índices y llaves foráneas.
- `INSERT` del usuario demo, 5 categorías, 3 cuentas y 5 transacciones.
- Codificación UTF-8 sin BOM.

Restauración:

```bash
mysql -u root -p < database/sql/gestor_financiero.sql
```

Regeneración desde la base de datos actual:

```bash
mysqldump --default-character-set=utf8mb4 --databases gestor_financiero ^
  > database/sql/gestor_financiero.sql
```

> Antes de regenerar, eliminar cualquier usuario personal que no deba entregarse y conservar solo el
> usuario `admin@gestorfinanciero.test`.

## 4. Reglas de saldo implementadas

1. Un ingreso aumenta el saldo de la cuenta.
2. Un gasto lo disminuye.
3. Un gasto nunca puede superar el saldo disponible.
4. El monto debe ser mayor que cero.
5. La categoría debe coincidir con el tipo de movimiento.
6. Editar revierte el efecto anterior y aplica el nuevo, incluso al cambiar de cuenta o de tipo.
7. Eliminar revierte el efecto del movimiento.
8. El saldo no se edita manualmente cuando la cuenta tiene movimientos.

La lógica vive en `app/Services/GestorSaldo.php` y se ejecuta dentro de transacciones con
`lockForUpdate()` para evitar condiciones de carrera.
