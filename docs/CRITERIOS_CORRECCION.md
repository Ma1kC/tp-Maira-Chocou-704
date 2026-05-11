# Criterios de corrección — Refactor inventario PHP

Documento para evaluar si el alumno pasó del código “espagueti” inicial a una base mantenible. Se puede usar como lista de verificación y como rúbrica con puntaje sugerido.

> **Nota:** el código base del repo usa **PDO** (MySQL). Donde este texto cite `mysqli` o `mysqli_connect`, interpretar el criterio de forma equivalente para PDO (`new PDO`, `prepare`, `query`, etc.).

---

## 1. Conexión a base de datos (peso sugerido: 20 %)

| Criterio | Qué se espera | Penalización típica si falla |
|----------|----------------|------------------------------|
| **Centralización** | Un solo lugar define host, usuario, contraseña, base y charset (p. ej. `config/database.php`, `includes/db.php` o similar). Ningún otro archivo llama a `mysqli_connect` directamente. | Repetir conexión en varios archivos = no cumple el objetivo principal. |
| **Uso uniforme** | Todos los scripts que acceden a la BD obtienen el recurso mysqli desde ese módulo (require/include una vez, o función tipo `getConnection()`). | Mezclar `db.php` en unos y conexión inline en otros = incumplimiento parcial. |
| **Charset explícito** | El charset (idealmente `utf8mb4`) se fija en el punto central, no olvidado en la mitad de los archivos. | Inconsistencia de encoding. |
| **Errores** | Mensaje o log claro si falla la conexión; en producción no exponer credenciales en pantalla. | `die()` con datos sensibles o sin manejo. |

---

## 2. Consultas y datos (peso sugerido: 25 %)

| Criterio | Qué se espera |
|----------|----------------|
| **SQL parametrizado** | IDs, cantidades, textos de usuario: sentencias preparadas (`mysqli_prepare` / bind) o capa equivalente. Evitar concatenar `$_GET`/`$_POST` en el SQL. |
| **Validación de entrada** | Tipos y rangos (stock ≥ 0, id entero positivo, cantidades coherentes) antes de tocar la BD. |
| **Ordenación / filtros** | Si hay `ORDER BY` o columnas dinámicas, lista blanca de campos permitidos, no concatenar el nombre de columna desde el usuario sin validar. |
| **Transacciones donde aplique** | Operaciones que deben ir juntas (p. ej. bajar stock + insertar movimiento) en `BEGIN` / `COMMIT` / `ROLLBACK` ante error. |

---

## 3. Estructura del proyecto (peso sugerido: 20 %)

| Criterio | Qué se espera |
|----------|----------------|
| **Separación mínima** | Lógica de acceso a datos separada de la presentación (por ejemplo capa de repositorios o al menos funciones en archivos dedicados vs. HTML mezclado con 50 líneas de SQL). |
| **Sin duplicación grave** | Consultas repetidas (listado de categorías, detalle de producto) extraídas a funciones o clases reutilizables. |
| **Convenciones** | Nombres de variables coherentes (`$mysqli` o `$db` de forma uniforme), mismo estilo de comillas/includes en todo el proyecto. |
| **Punto de entrada claro** | Rutas o front controller si se introduce; si no, al menos includes ordenados y rutas relativas predecibles. |

---

## 4. Seguridad y HTTP (peso sugerido: 15 %)

| Criterio | Qué se espera |
|----------|----------------|
| **Acciones destructivas** | Borrados o cambios críticos con `POST` (o token CSRF), no solo un enlace GET con `?si=1`. |
| **Salida HTML** | Textos que vienen de la BD o del usuario escapados con `htmlspecialchars` (u otro mecanismo) al imprimir en HTML. |
| **Sesión / auth** | Si el enunciado pide login, sesión segura y comprobación en páginas privadas (este proyecto inicial puede no tenerlo; ajustar según consigna). |

---

## 5. Experiencia de uso y mantenimiento (peso sugerido: 10 %)

| Criterio | Qué se espera |
|----------|----------------|
| **Redirecciones** | Tras POST exitoso, `POST-REDIRECT-GET` para evitar reenvío del formulario al refrescar. |
| **Mensajes** | Feedback claro (éxito / error) sin depender solo de `echo` suelto en medio del flujo. |
| **Paginación** | Límites y offsets validados (enteros, máximos razonables). |

---

## 6. Estilo y calidad técnica (peso sugerido: 10 %)

| Criterio | Qué se espera |
|----------|----------------|
| **Legibilidad** | Indentación, nombres descriptivos, funciones no gigantes. |
| **Errores mysqli** | Comprobar resultado de `prepare`/`execute` o al menos de operaciones críticas; no ignorar fallos silenciosamente en flujos importantes. |
| **Comentarios** | Solo donde aporten (decisiones no obvias); no compensar código ilegible con comentarios enormes. |

---

## 7. Interfaz, CSS y mockup (peso sugerido: 10 %)

*El docente puede fusionar este bloque con “Experiencia de uso” o ponderarlo aparte; si no se evalúa UI en el curso, omitir esta sección.*

| Criterio | Qué se espera |
|----------|----------------|
| **Coherencia visual** | CSS aplicado en **todas** las pantallas del flujo (inventario, login, panel, formularios, listados). Misma familia tipográfica, paleta y ritmo de espacios; no mezclar tres estilos inconexos sin explicación. |
| **Mockup y trazabilidad** | Mockup propio (imagen, Figma, PDF, etc.) entregado o enlazado desde el informe; debe poder compararse con el CSS y las pantallas finales. |
| **Informe** | En el informe (Word/PDF en `docs/` u otro canal del curso): mockup o enlace, y **breve texto** que relacione el mockup con lo implementado en CSS. |
| **Calidad de implementación** | Tablas y formularios legibles; botones y enlaces distinguibles; estado `:focus` visible en controles; mensajes de error/éxito integrados al diseño. |
| **No decoración arbitraria** | Evitar “CSS al azar” sin vínculo al mockup ni al informe (debe verse el hilo mockup → pantallas). |

---

## Rúbrica rápida (nota orientativa)

| Nivel | Descripción |
|-------|-------------|
| **Insuficiente** | Conexión aún duplicada o mezcla centralizada + inline. SQL concatenado con entrada del usuario sin cambios. |
| **Básico** | Conexión centralizada y usada en la mayoría de archivos; alguna mejora puntual (escape o prepared en un solo flujo). |
| **Aceptable** | Conexión única + prepared statements en altas/bajas/ventas + separación parcial vista/lógica + acciones sensibles por POST. |
| **Muy bien** | Lo anterior + transacciones en venta + ordenación/filtros con whitelist + escape sistemático en vistas + estructura de carpetas clara + **CSS coherente** enlazado en todas las vistas principales. |
| **Excelente** | Lo anterior + interfaz **alineada a un mockup** entregado o enlazado desde el informe / `docs/` + **breve explicación** en el informe de cómo el CSS sigue ese mockup + foco visible en formularios. |

---

## Lista de verificación para el corrector (sí / no)

- [ ] ¿Existe un único módulo de conexión y **todos** los PHP lo utilizan?
- [ ] ¿Algún archivo aún contiene `mysqli_connect(`? (debería ser **ninguno** salvo el central o tests aislados.)
- [ ] ¿Ventas y movimientos son atómicos (transacción) o justificado si no aplica?
- [ ] ¿Eliminación de producto ya no depende solo de GET?
- [ ] ¿`ver_productos.php` no concatena columnas de `ORDER BY` desde usuario sin whitelist?
- [ ] ¿Las vistas escapan datos al mostrar HTML?
- [ ] ¿Hay CSS en **todas** las pantallas relevantes y se ve una misma línea visual?
- [ ] ¿Hay **mockup** (propio) entregado o enlazado y **coherencia** razonable entre mockup, CSS y pantallas?
- [ ] ¿Los formularios y botones tienen estados de foco/hover razonables?

---

## Notas para quien corrige

- Los pesos porcentuales son orientativos; pueden ajustarse si la consigna del curso prioriza solo refactor de conexión o también seguridad.
- Si el alumno documenta decisiones (p. ej. por qué eligió PDO vs mysqli), valorar comunicación técnica dentro del criterio de estructura o estilo.
- Código que “funciona” en local pero viola criterios de seguridad o centralización debe poder calificarse como incompleto respecto a este estándar, aunque la demo parezca correcta.
- Para el ítem **UI / mockup**: valorar la **coherencia** entre mockup, informe y pantallas; un sitio “lindo” pero sin mockup ni mención en el informe debería calificarse bajo en ese ítem.
