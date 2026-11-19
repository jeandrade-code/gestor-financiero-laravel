# Pruebas

## 1. Pruebas automatizadas

Las pruebas usan **SQLite en memoria** (`phpunit.xml`), por lo que no modifican la base de datos de
demostración.

```bash
php artisan view:clear
php artisan test --compact
```

Resultado verificado:

```
{"tool":"phpunit","result":"passed","tests":47,"passed":47,"assertions":132}
```

### Cobertura por archivo

| Archivo | Qué verifica |
| ------- | ------------ |
| `tests/Feature/SaldoTest.php` | Ingreso suma, gasto resta, caso del taller ($330.000), edición de monto/tipo/cuenta, eliminación, monto > 0 y gasto ≤ saldo |
| `tests/Feature/TransaccionCrudTest.php` | Alta con efecto en saldo, coherencia categoría/tipo, nombres (no IDs) en el listado, saldo no editable, tipo de categoría protegido |
| `tests/Feature/EliminacionProtegidaTest.php` | Bloqueo de cuenta/categoría con movimientos, eliminación permitida sin movimientos, módulos protegidos por autenticación |
| `tests/Feature/VistasTest.php` | Las vistas de los tres módulos renderizan; los datos se conservan tras un error de validación |
| `tests/Feature/Auth/*` | Login, logout, registro, verificación de correo, recuperación y actualización de contraseña, confirmación de contraseña |
| `tests/Feature/ProfileTest.php` | Visualización y actualización del perfil, cambio de contraseña, eliminación de cuenta |
| `tests/Feature/ExampleTest.php` | Landing y ruta de login accesibles |
| `tests/Unit/ExampleTest.php` | Prueba unitaria base |

## 2. Verificación funcional en navegador

Se ejecutó una secuencia end-to-end sobre Chrome headless (CDP) con el usuario demo. El resultado quedó en
`capturas/prueba-saldo/resumen.json` y las imágenes en ese mismo directorio.

| Paso | Resultado |
| ---- | --------- |
| Crear cuenta con saldo $200.000 | Correcto |
| Intentar gasto con monto negativo | Mensaje *El monto debe ser mayor que cero.* |
| Intentar gasto mayor al saldo | Mensaje *El gasto supera el saldo disponible…* |
| Registrar ingreso de $150.000 | Saldo $350.000,00 |
| Registrar gasto de $20.000 | Saldo $330.000,00 |
| Editar el ingreso a $100.000 | Saldo $280.000,00 |
| Eliminar el gasto de $20.000 | Saldo $300.000,00 |
| Eliminar cuenta con movimientos | Bloqueado con mensaje en español |
| Eliminar categoría con movimientos | Bloqueado con mensaje en español |
| Limpieza de la cuenta de prueba | Cuenta eliminada |

Errores JavaScript de consola: **ninguno**.

## 3. Verificación visual y responsive

Las capturas de `capturas/diseno/` se tomaron a 1440 px (desktop) y 390 px (móvil), en modo claro y oscuro.

Comprobaciones realizadas:

- Sin desbordamiento horizontal en móvil.
- Tablas apiladas con etiquetas en pantallas pequeñas.
- Menú lateral colapsable: 248 px → 72 px, etiquetas ocultas, estado persistido en `localStorage`.
- Gráfica del dashboard renderizada como SVG (sin librerías externas).
- Sin errores JS (`capturas/diseno/errores.json` vacío).

Para volver a tomar las capturas con el servidor y CDP activos:

```bash
node capture-diseno.cjs gestor-financiero/docs/capturas/diseno
node prueba-saldo.cjs gestor-financiero/docs/capturas/prueba-saldo
```

> Los scripts de captura se usaron durante el desarrollo y viven fuera del repositorio; las imágenes y los
> resúmenes sí forman parte de la entrega.

## 4. Comandos útiles antes de entregar

```bash
vendor/bin/pint --dirty --format agent
php artisan view:clear
php artisan test --compact
npm run build
php artisan migrate:status
```
