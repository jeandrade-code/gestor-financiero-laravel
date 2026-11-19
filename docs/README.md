# Documentación del proyecto

Este directorio contiene la documentación entregable del **Gestor Financiero**, desarrollado para el
Taller Final de Programación III.

| Documento | Contenido |
| --------- | --------- |
| [INSTALACION.md](INSTALACION.md) | Requisitos, instalación local, configuración y puesta en marcha |
| [CONFIGURACION.md](CONFIGURACION.md) | Variables de entorno, conexión MySQL, idioma y compilación de assets |
| [BASE_DATOS.md](BASE_DATOS.md) | Esquema, relaciones, datos de prueba y respaldo SQL |
| [ARQUITECTURA.md](ARQUITECTURA.md) | Estructura, capas, rutas y flujo de una petición |
| [MANUAL_USUARIO.md](MANUAL_USUARIO.md) | Uso de los tres módulos y del panel |
| [PRUEBAS.md](PRUEBAS.md) | Pruebas automatizadas y verificación funcional en navegador |
| [SUSTENTACION.md](SUSTENTACION.md) | Guion de sustentación en parejas y caso de cálculo de saldo |
| [DISENO.md](DISENO.md) | Sistema visual, responsive, accesibilidad y capturas |

## Acceso rápido

```bash
composer install
copy .env.example .env
php artisan key:generate
npm install
npm run build
php artisan migrate --seed
php artisan serve
```

- Aplicación: `http://127.0.0.1:8000`
- Usuario: `admin@gestorfinanciero.test`
- Contraseña: `password`

## Verificación rápida

```bash
php artisan test --compact
```

Resultado actual: **47 pruebas, 132 aserciones, todas correctas**.

## Capturas

- `capturas/` — flujo funcional y caso de saldo del taller.
- `capturas/diseno/` — diseño desktop, móvil, modo oscuro, menú colapsado y gráfica.
- `capturas/prueba-saldo/` — secuencia completa `$200.000 → $350.000 → $330.000`, edición,
  eliminación y bloqueos.
