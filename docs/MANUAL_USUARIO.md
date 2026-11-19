# Manual de usuario

## 1. Ingreso

1. Abrir la URL de la aplicación.
2. En la portada, seleccionar **Ya tengo cuenta**.
3. Ingresar `admin@gestorfinanciero.test` y `password`.
4. Opcionalmente marcar **Recordarme**. Si se olvidó la contraseña, usar **¿Olvidó su contraseña?**
   (el correo se escribe al log porque `MAIL_MAILER=log`).

El registro de nuevos usuarios está disponible desde **Crear una cuenta**. Después de registrarse puede
solicitarse la verificación del correo antes de acceder a los módulos.

## 2. Panel principal

El panel resume:

- **Saldo total** de todas las cuentas.
- **Ingresos totales** y **Gastos totales** acumulados, con su cantidad de movimientos.
- **Balance neto** (ingresos menos gastos).
- **Flujo de efectivo**: gráfica de líneas con ingresos y gastos de los últimos seis meses.
- **Últimos movimientos**: cuenta, categoría, fecha, tipo y monto de los seis más recientes.
- **Cuentas**: saldo y cantidad de movimientos de cada una.

Acciones del panel:

| Acción | Dónde |
| ------ | ----- |
| Registrar un movimiento | Botón **Nuevo movimiento** en el encabezado |
| Ver todos los movimientos | **Ver transacciones** / **Ver todas** |
| Gestionar cuentas | **Gestionar** en la tarjeta de cuentas |
| Crear una cuenta | **Añadir cuenta** |
| Cambiar tema | Icono de luna/sol en la barra superior |
| Minimizar el menú | Botón de chevrons en la barra superior (solo desktop) |
| Abrir el menú en móvil | Botón de tres líneas en la barra superior |

El menú minimizado se recuerda entre páginas y recargas. En móvil el menú se abre como drawer y siempre
muestra las etiquetas completas.

## 3. Categorías

Ruta: **Categorías** en el menú lateral.

- **Crear:** botón **Nueva categoría**. Se indican nombre, tipo (ingreso o gasto) y descripción opcional.
- **Listar:** tabla con nombre, tipo, descripción y cantidad de movimientos. Filtros por texto y tipo.
- **Editar:** botón de lápiz. No se puede cambiar el tipo de una categoría que ya tiene movimientos.
- **Eliminar:** botón de basura. Si la categoría tiene movimientos, el botón aparece deshabilitado y,
  aunque se envíe la petición, el servidor responde: *No se puede eliminar la categoría porque tiene
  transacciones asociadas.*

## 4. Cuentas

Ruta: **Cuentas** en el menú lateral.

- **Crear:** botón **Nueva cuenta**. Se indican nombre, saldo inicial, moneda y descripción.
- **Listar:** tarjetas con saldo actual y cantidad de movimientos. Filtro por texto.
- **Editar:** el saldo aparece de solo lectura cuando la cuenta ya tiene movimientos, porque se calcula
  automáticamente. Sí se pueden cambiar nombre, moneda y descripción.
- **Eliminar:** solo disponible si la cuenta no tiene movimientos; de lo contrario se muestra el mensaje
  *No se puede eliminar la cuenta porque tiene movimientos asociados.*

## 5. Transacciones

Ruta: **Transacciones** en el menú lateral.

### Registrar

1. Botón **Nueva transacción**.
2. Seleccionar la cuenta. El selector muestra el saldo disponible de cada una.
3. Elegir el tipo: **Ingreso** o **Gasto**.
4. Seleccionar una categoría del tipo elegido; las categorías del otro tipo se ocultan.
5. Ingresar monto (> 0), fecha y descripción opcional.
6. Guardar.

Si el gasto supera el saldo de la cuenta, se muestra: *El gasto supera el saldo disponible de la cuenta*
junto al saldo formateado. Los datos escritos se conservan para corregirlos.

### Listar y filtrar

La tabla muestra **nombres** de cuenta y categoría, nunca IDs. Filtros disponibles: texto, tipo y cuenta.
La paginación mantiene los filtros activos.

### Editar

Al guardar se revierte el efecto anterior y se aplica el nuevo, incluso si cambia la cuenta, el tipo o el
monto. La barra lateral muestra el movimiento original para comparar.

### Eliminar

Se pide confirmación. El saldo de la cuenta se revirtirá automáticamente.

## 6. Perfil

Desde el menú de usuario o **Mi perfil** se puede actualizar nombre y correo, cambiar contraseña y
eliminar la cuenta. Para eliminar se requiere confirmar la contraseña.

## 7. Consejos de uso

- Use el botón **Nuevo movimiento** del panel para cargar ingresos y gastos rápidamente.
- Si una categoría no aparece al registrar un gasto, créela primero desde **Categorías**.
- Para comprobar el efecto de un movimiento, compare el saldo de la cuenta antes y después en **Cuentas**.
- En pantallas pequeñas las tablas se apilan y el menú se convierte en drawer.
