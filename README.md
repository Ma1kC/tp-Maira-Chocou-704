# Trabajo práctico: refactor de inventario (PHP + MySQL)

Este repositorio contiene un **sistema de inventario de ejemplo** escrito a **propósito** con malas prácticas. La consigna es **mejorar** el proyecto sin cambiar el comportamiento funcional esperado salvo lo que indique el docente.

---

## Qué hay en el repo

| Ruta | Descripción |
|------|-------------|
| `*.php` (raíz) | Páginas PHP del inventario y del login (código legacy intencional). |
| `db/inventario.sql` | Script para crear la base `inventario`, tablas y datos de ejemplo. |
| `docs/` | Documentación: guía breve del mockup (`MOCKUP_REFERENCIA.md`), informe en Word/PDF u otro material que indique el docente. |

---

## Credenciales de prueba

### Conexión PHP → MySQL (como viene en el código de ejemplo)

| Parámetro | Valor por defecto |
|-----------|-------------------|
| Host | `localhost` |
| Base de datos | `inventario` |
| Usuario | `root` |
| Contraseña | *(vacía)* |

Ajustalos en cada `new PDO(...)` o en el módulo central que implementen.

### Usuario del login web (tabla `usuarios`, creado al importar el SQL)

| Campo | Valor |
|-------|--------|
| Correo | `admin@test.com` |
| Contraseña | `demo123` |

**Importante:** con el código inicial a propósito, **ese usuario no puede iniciar sesión** hasta corregir el desajuste entre los nombres de columnas en PHP y los de la base, y unificar la sesión.

---

## Consigna

### Objetivo general

Refactorizar el proyecto para que sea **más seguro**, **más fácil de mantener** y **coherente** con una base de datos bien alineada, sin dejar de cumplir las funcionalidades que hoy intenta cubrir el código (listado, detalle, venta, altas/bajas, categorías, movimientos, búsqueda y flujo de login). Además, debe quedar como un **sitio web cuidado**: **CSS** unificado y el diseño **basado en un mockup** que documenten en el informe (ver punto 5).

### Requisitos mínimos

1. **Conexión a la base de datos**  
   Centralizar la conexión (PDO u otra capa acordada con el curso) en **un único módulo**. Hoy el código repite `new PDO(...)` en cada archivo; la entrega no debe repetir esa configuración en todos los scripts.

2. **Alineación con la base de datos**  
   Revisar **todas** las consultas y los **índices de arrays** resultantes (`fetch()` / `FETCH_ASSOC`, etc.) para que coincidan con el esquema definido en `db/inventario.sql`. El login y el listado de usuarios deben **funcionar** con el usuario de prueba (`admin@test.com` / `demo123`; ver **Credenciales de prueba**).

3. **Buenas prácticas HTTP y seguridad básica**  
   - Acciones que modifiquen o borren datos deben usar **POST** (o mecanismo equivalente con protección frente a CSRF si el curso lo exige).  
   - Evitar concatenar datos de usuario directamente en SQL; usar **sentencias preparadas** donde corresponda.  
   - Escapar salida HTML cuando se muestren datos dinámicos.

4. **Coherencia de sesión (login)**  
   Unificar nombres de claves de `$_SESSION` entre el procesamiento del login, el panel y el cierre de sesión, de modo que un usuario autenticado pueda entrar al panel y salir correctamente.

5. **Interfaz: CSS y mockup**  
   - Aplicar **CSS** para un sitio ordenado y legible (tablas, formularios, login).  
   - **Creá un mockup** (por ejemplo Figma, Canva o imagen) del sistema que están desarrollando y **basá en él** el diseño de las pantallas y los estilos. En el informe incluí el mockup, una captura o enlace (ver `docs/MOCKUP_REFERENCIA.md` como recordatorio breve).  
   - Objetivo: una misma **línea visual** en todas las pantallas del flujo.

6. **Entrega**  
   Seguir las indicaciones del aula (branch, zip, fecha, parejas, etc.). Incluir **informe** en `docs/` (u otra ubicación que indique el docente) con problemas detectados, decisiones técnicas y de interfaz, y limitaciones conocidas.

### Opcional / según cronograma

- Transacciones en **venta** (actualizar stock + registrar movimiento de forma atómica).  
- Lista blanca para ordenamiento o filtros dinámicos en listados.  
- Separar capa de acceso a datos de las vistas (plantillas o includes mínimos).  
- **Variables CSS** (`:root`), modo oscuro o responsive, si el docente lo pide.

### Restricciones

- No borrar la consigna del repo en la entrega (salvo indicación contraria).  
- Mantener el proyecto **ejecutable** en el entorno acordado (por ejemplo PHP + MySQL/MariaDB).  
- Si se cambia el esquema SQL, documentar migraciones o adjuntar SQL actualizado en `db/`.

---

## Puesta en marcha rápida

1. Importar `db/inventario.sql` en MySQL o MariaDB (phpMyAdmin o cliente por consola).  
2. Ajustar usuario/contraseña/host de la base en **todos** los `new PDO(...)` (o en el módulo central que creen). El código de ejemplo usa `root` sin contraseña, base `inventario` y host `localhost` (debe coincidir en **todos** los archivos PHP que conectan).  
3. Apuntar el **document root** del servidor web a la **carpeta del proyecto** (`refactor`), o para pruebas locales, desde esa carpeta:  
   `php -S localhost:8080 -t .`

---

## Evaluación

Se tendrá en cuenta el **cumplimiento de los puntos de esta consigna**: conexión centralizada, alineación con la base de datos, buenas prácticas de seguridad y HTTP, sesión de login coherente, interfaz con CSS basada en mockup e informe en `docs/`, según lo que pida el docente en el aula.

---

## Aviso

El código inicial **no** es un modelo de producción: incluye patrones problemáticos a **propósito** para practicar refactor y lectura de código ajeno.
