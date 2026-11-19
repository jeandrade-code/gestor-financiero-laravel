# Arquitectura

## 1. Stack

- **Backend:** Laravel 13, PHP 8.4, Eloquent ORM, Blade.
- **Autenticación:** Laravel Breeze (sesiones, verificación de correo, recuperación de contraseña).
- **Base de datos:** MySQL / MariaDB.
- **Frontend:** Blade + componentes, Tailwind CSS 3, Alpine.js, Vite.
- **Gráfica:** módulo propio `resources/js/charts.js` que genera SVG y se empaqueta con Vite (sin dependencias extra).

## 2. Estructura relevante

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── DashboardController.php      # KPIs, últimas transacciones, cuentas y serie de la gráfica
│   │   ├── CategoriaController.php
│   │   ├── CuentaController.php
│   │   ├── TransaccionController.php
│   │   └── LandingController.php
│   ├── Requests/
│   │   ├── StoreCategoriaRequest.php / UpdateCategoriaRequest.php
│   │   ├── StoreCuentaRequest.php / UpdateCuentaRequest.php
│   │   ├── StoreTransaccionRequest.php / UpdateTransaccionRequest.php
│   │   └── Concerns/ValidaTransaccion.php
│   └── Middleware/
├── Models/                               # Categoria, Cuenta, Transaccion, User
├── Services/GestorSaldo.php              # Reglas de negocio del saldo
└── View/Components/                      # Layouts, botones, tablas, estados vacíos, etc.
resources/
├── css/app.css                           # Tokens, componentes y estilos del shell
├── js/app.js                             # Alpine, password toggle, submit loading
├── js/charts.js                          # Gráfica SVG del dashboard
└── views/                                # Blade de autenticación, landing y módulos
database/
├── migrations/                           # Esquema del dominio
├── seeders/                              # Datos de prueba
└── sql/gestor_financiero.sql             # Respaldo entregable
```

## 3. Rutas y protección

```php
Route::get('/', [LandingController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::resource('categorias', CategoriaController::class)->except('show');
    Route::resource('cuentas', CuentaController::class)->except('show');
    Route::resource('transacciones', TransaccionController::class)->except('show');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/profile', ...)->name('profile.edit');
    Route::patch('/profile', ...)->name('profile.update');
    Route::delete('/profile', ...)->name('profile.destroy');
});
```

Los tres módulos y el panel están disponibles solo para usuarios autenticados y con correo verificado.
`php artisan route:list --except-vendor` muestra 37 rutas propias en total.

## 4. Flujo de una petición ( registrar transacción )

1. El formulario envía `POST /transacciones` con CSRF.
2. `StoreTransaccionRequest` valida cuenta, categoría, tipo, monto > 0, fecha y coherencia categoría/tipo.
3. `TransaccionController@store` llama a `GestorSaldo::registrar()`.
4. `GestorSaldo` abre una transacción, bloquea la cuenta (`lockForUpdate`), verifica saldo suficiente,
   crea la transacción y ajusta el saldo. Si algo falla, se revierte todo.
5. El controlador redirige al listado con un mensaje de sesión `estado`.
6. La vista muestra el mensaje mediante el componente `x-alert`.

La edición sigue el mismo flujo, pero `GestorSaldo::actualizar()` primero revierte el efecto anterior.
La eliminación usa `GestorSaldo::eliminar()` para reversar el efecto y borrar el registro.

## 5. Capa de presentación

- `layouts/app.blade.php`: shell autenticado con sidebar, topbar, footer y stacks `modals` / `scripts`.
- `layouts/guest.blade.php`: layout de autenticación con panel de marca.
- `components/`: `page-header`, `alert`, `card`, `empty-state`, `type-badge`, `x-brand-mark`, etc.
- Cada módulo tiene `index`, `create`, `edit` y una parcial `formulario` reutilizable en transacciones.
- Los listados usan `withQueryString()` para conservar filtros y paginación.

### Menú lateral colapsable

El estado se guarda en `localStorage` (`sidebar = collapsed | expanded`) y se aplica antes de pintar
mediante un script inline que agrega la clase `sidebar-collapsed` al `<html>`. Alpine mantiene el estado
reactivo y el botón del topbar alterna el valor. En pantallas `>= 1024px` el ancho pasa de 248 px a 72 px,
se ocultan las etiquetas y el contenido ocupa el espacio liberado; en móvil el drawer conserva las etiquetas.

### Gráfica del dashboard

`DashboardController::flujoMensual()` genera seis puntos (meses) con ingresos y gastos. La vista serializa
el arreglo en `data-series` y `resources/js/charts.js` construye un SVG de solo líneas con ejes y rejilla. Vite incluye el módulo en `public/build/assets/app-*.js`. Los colores de la malla se leen de
variables CSS, por lo que la gráfica respeta el modo oscuro sin volver a renderizarse (la línea de
ingresos se atenúa en modo oscuro).

## 6. Convenciones

- Controladores delgados; reglas de negocio en `app/Services/`.
- `FormRequest` para validación y mensajes en español (`lang/es/validation.php`).
- Rutas nombradas y `route()` para generar enlaces.
- Nombres de variables y métodos descriptivos; tipos de retorno explícitos.
- Formateo con Laravel Pint (`vendor/bin/pint --dirty`).
- Pruebas feature con SQLite en memoria; nunca afectan la base de demostración.
