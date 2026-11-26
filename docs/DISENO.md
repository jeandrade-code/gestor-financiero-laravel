# Diseño de interfaz

La interfaz se rediseñó por completo con una dirección visual denominada **Evergreen**: un producto SaaS
sobrio, editorial y confiable, lejos del aspecto genérico de los templates. Se conservó el sistema de
íconos SVG porque son claros y ligeros; se agregó una marca propia (`x-brand-mark`).

## 1. Principios

1. **Contenido antes que decoración.** Jerarquías claras, mucho espacio en blanco y una sola acción principal por pantalla.
2. **Datos legibles.** Los montos usan `JetBrains Mono` con `tabular-nums`; los ingresos en verde y los gastos en terracota. En modo oscuro el verde se reduce a un acento mínimo: superficies, enlaces y cifras de ingreso pasan a neutros y solo permanece una línea verde apagada en la gráfica.
3. **Máscara monetaria.** Los campos de saldo y monto muestran el formato `es-CO` mientras se escribe (miles con punto, decimales con coma) y guardan el valor numérico en un campo oculto. La máscara es propia, sin dependencias npm adicionales.
3. **Densidad controlada.** Botones en tres tamaños (`sm`, `md`, `lg`), íconos de 14–18 px y KPIs de 20–28 px.
4. **Consistencia espacial.** Escala de 4 px, radios de 6–12 px y sombras muy suaves.
5. **Accesibilidad.** Etiquetas, `aria-*`, foco visible, contraste suficiente y `prefers-reduced-motion`.

## 2. Paleta

| Rol | Color | Uso |
| --- | ----- | --- |
| Marca | `brand-700` `#1b5a45` | Botones primarios, enlaces, acentos |
| Neutro claro | `neutral-50` `#fafaf8` | Fondo de página |
| Neutro oscuro | `neutral-950` `#0c110e` | Fondo en modo oscuro |
| Ingreso | `income-500` `#2f8c67` | Montos positivos, serie de la gráfica |
| Gasto | `expense-500` `#b4523f` | Montos negativos, serie de la gráfica |
| Alerta | `warning-500` `#b0851f` | Advertencias contextuales |

Los neutros tienen un leve subtono verde piedra para evitar el gris azulado por defecto de Tailwind.

## 3. Tipografía

| Rol | Fuente | Ejemplo de uso |
| --- | ------ | -------------- |
| Interfaz | Inter | Cuerpo, tablas, formularios |
| Títulos destacados | Instrument Serif | Hero de landing, encabezados de sección |
| Números y código | JetBrains Mono | Saldos, fechas, etiquetas de ejes |

Escala: `display-xl/md`, `heading-sm/md`, `body-lg/body-sm`, `caption`, `micro`. Las cifras grandes usan
`kpi` y `kpi-sm` con seguimiento negativo para un aspecto más preciso.

## 4. Componentes

- **Shell autenticado:** sidebar fija en desktop (248 px), drawer en móvil, topbar sticky, footer discreto.
- **Tarjetas:** `card` con borde 1 px y sombra `card`; se usan para KPIs, listas y formularios.
- **Botones:** `btn-primary`, `btn-secondary`, `btn-ghost`, `btn-outline`, `btn-destructive`; tamaños `sm/md/lg`.
- **Formularios:** etiquetas arriba, ayudas cortas, errores por campo y conservación de datos (`old()`).
- **Estados vacíos:** ilustración SVG, título, descripción y una acción principal.
- **Badges:** tipo de movimiento y estado de cuenta/categoría.
- **Tablas:** cabecera compacta, filas con hover y versión apilada en móvil (`table-stack`).

## 5. Resumen de cambios aplicados

| Antes | Después |
| ----- | ------- |
| Aviso redundante de «nueva versión» en el encabezado | Eliminado por completo |
| Íconos y tipografías sobredimensionadas | Escalas controladas y proporción consistente |
| Menú lateral siempre abierto | Botón para minimizarlo en desktop, con persistencia |
| Dashboard sin visualización | Gráfica SVG de ingresos/gastos generada desde datos reales y empaquetada con Vite |
| Bloques explicativos repetidos | Se eliminaron el tip del dashboard, la fila de confianza del hero y la franja de datos duplicada |
| Sidebar de formularios extenso | Una sola tarjeta con las reglas esenciales |
| Footer simple | Footer con marca, enlaces y contexto del proyecto |

## 6. Menú colapsable

El botón de la barra superior alterna entre 248 px y 72 px. Al colapsar:

- Se ocultan etiquetas, títulos de sección, avatar y datos del usuario; en la parte inferior solo queda
  el botón de cerrar sesión.
- Los íconos se centran y conservan `title` / `aria-label` para accesibilidad.
- El contenido principal ocupa el espacio liberado mediante la variable CSS `--sidebar-width`.
- El estado se guarda en `localStorage` y se aplica antes del primer pintado para evitar parpadeos.

En móvil el drawer no se ve afectado: siempre muestra las etiquetas completas.

## 7. Gráfica

`resources/js/charts.js` genera una gráfica de **solo líneas** (dos polilíneas, sin áreas ni puntos) sin
dependencias externas:

- Seis meses, ingresos vs. gastos; cada serie es una línea recta continua.
- Rejilla discreta, etiquetas compactas en el eje Y y abreviaturas de mes en el eje X.
- Colores de las líneas alineados con `income-500` y `expense-500`.
- La rejilla y el verde de la serie se definen en CSS, por lo que en modo oscuro la línea de ingresos se apaga a `#55705f`.
- Se importa desde `resources/js/app.js`, por lo que Vite la incluye en el bundle final.

## 8. Responsive y accesibilidad

- Breakpoints `sm`, `lg` y `xl`; tablas apiladas y formularios de una columna en móvil.
- `meta viewport` con `viewport-fit=cover` y `interactive-widget=resizes-content`.
- Safe-area para pantallas con notch.
- Foco visible en todos los controles y enlace de salto al contenido principal.
- `aria-current` en el elemento activo del menú, `aria-expanded` en el menú de usuario y `aria-pressed`
  en el botón de colapso.
- `prefers-reduced-motion` desactiva animaciones.
- Inputs con fuente de 16 px en pantallas táctiles para evitar zoom automático.

## 9. Capturas

| Captura | Contenido |
| ------- | --------- |
| `diseno/landing-desktop.png`, `landing-desktop-dark.png`, `landing-mobile.png` | Portada |
| `diseno/login-desktop.png`, `register-desktop.png` | Autenticación |
| `diseno/dashboard-desktop.png`, `dashboard-desktop-dark.png`, `dashboard-desktop-colapsado.png` | Panel, modo oscuro y menú minimizado |
| `diseno/dashboard-mobile.png`, `dashboard-mobile-menu.png` | Panel móvil y drawer |
| `diseno/categorias-*.png`, `cuentas-*.png`, `transacciones-*.png` | Módulos y formularios |
| `diseno/perfil-desktop.png` | Perfil |
| `prueba-saldo/prueba-*.png` | Caso de saldo y validaciones |

`diseno/errores.json` está vacío: no se registraron errores de JavaScript durante las capturas.
