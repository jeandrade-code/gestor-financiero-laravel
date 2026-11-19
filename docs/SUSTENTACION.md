# Guion de sustentación (en parejas)

## Reparto sugerido

| Integrante | Responsabilidad durante la demo |
| ---------- | ------------------------------- |
| Compañero/a 1 | Navegación, autenticación, cuentas y categorías |
| Compañero/a 2 | Transacciones, cálculo de saldo, edición/eliminación y bloqueos |

## 1. Introducción (1 minuto)

> “El proyecto es un Gestor Financiero en Laravel 13 con MySQL y Breeze. Tres módulos —categorías, cuentas
> y transacciones— están disponibles solo para usuarios autenticados. El saldo de cada cuenta no se edita a
> mano: se calcula a partir de los movimientos.”

Mostrar:

1. Ruta `/` (landing).
2. Inicio de sesión con `admin@gestorfinanciero.test` / `password`.
3. Panel con KPIs, gráfica de flujo de efectivo y últimos movimientos.

## 2. Esquema y datos de prueba (1 minuto)

Abrir `database/sql/gestor_financiero.sql` o el phpMyAdmin y señalar:

- `categorias`: 5 registros (2 ingresos, 3 gastos).
- `cuentas`: 3 registros; Caja con $330.000,00.
- `transacciones`: 5 registros con llaves foráneas a cuenta y categoría.
- Las llaves foráneas impiden borrar cuentas/categorías con movimientos.

## 3. Caso central del taller (3 minutos)

### Paso A — saldo inicial

En **Cuentas → Nueva cuenta**, crear:

| Campo | Valor |
| ----- | ----- |
| Nombre | `Cuenta de prueba` |
| Saldo inicial | `200000` |
| Moneda | `COP` |

Mostrar la tarjeta con **$200.000,00**.

### Paso B — ingreso

**Transacciones → Nueva transacción**:

- Cuenta: `Cuenta de prueba`
- Tipo: `ingreso`
- Categoría: `Salario`
- Monto: `150000`
- Descripción: `Ingreso de prueba para la defensa`

Volver a **Cuentas**: saldo **$350.000,00**.

### Paso C — gasto

Repetir con:

- Tipo: `gasto`
- Categoría: `Servicios públicos`
- Monto: `20000`
- Descripción: `Gasto de prueba para la defensa`

Volver a **Cuentas**: saldo **$330.000,00**.

> Afirmación clave: *$200.000 + $150.000 − $20.000 = $330.000*, coincide con el saldo mostrado.

Capturas: `capturas/prueba-saldo/prueba-01…05`.

## 4. Edición y eliminación (2 minutos)

### Editar el ingreso

1. En **Transacciones**, filtrar por la cuenta de prueba.
2. Editar `Ingreso de prueba para la defensa` y cambiar el monto a `100000`.
3. Guardar. El saldo pasa de $330.000 a **$280.000**, porque se revirtieron $150.000 y se aplicaron $100.000.

Capturas: `prueba-06` y `prueba-07`.

### Eliminar el gasto

1. En el listado, eliminar `Gasto de prueba para la defensa`.
2. Confirmar. El saldo pasa de $280.000 a **$300.000**, porque se reversó el gasto de $20.000.

Captura: `prueba-08`.

### Cambiar cuenta y tipo (mencionar)

En la edición se puede cambiar la cuenta o el tipo; el servicio `GestorSaldo` revierte el efecto en la
cuenta anterior y lo aplica en la nueva. Está cubierto por `SaldoTest`.

## 5. Validaciones (1 minuto)

Mostrar rápidamente:

- Monto `-5` → *El monto debe ser mayor que cero.* (`prueba-02`).
- Gasto `99999999` en Caja → *El gasto supera el saldo disponible de la cuenta (330.000,00 COP).*
  (`prueba-03`).
- Categoría de ingreso con tipo gasto → error de coherencia.
- Intentar borrar `Bancolombia` → *No se puede eliminar la cuenta porque tiene movimientos asociados.*
  (`prueba-09`).
- Intentar borrar `Salario` → *No se puede eliminar la categoría porque tiene transacciones asociadas.*
  (`prueba-10`).

## 6. Detalles de UX para destacar (1 minuto)

- Listados con nombres de cuenta y categoría, no IDs.
- Filtros y paginación que conservan la búsqueda.
- Menú lateral minimizable en desktop (se recuerda entre páginas).
- Gráfica SVG generada desde datos reales del dashboard y empaquetada con Vite.
- Diseño responsive, modo oscuro y estados vacíos.
- Mensajes de éxito/error y conservación de datos al fallar un formulario.

## 7. Cierre (30 segundos)

```bash
php artisan test --compact
```

Mostrar: **47 pruebas, 132 aserciones, todas correctas**.

> No olvidar eliminar la `Cuenta de prueba` al terminar; las capturas `prueba-11` muestran la limpieza.
