# StockMaster - Sistema de Gestión de Inventario

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.10-red.svg" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue.svg" alt="PHP">
  <img src="https://img.shields.io/badge/Tailwind_CSS-3.1.0-38B2AC.svg" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Alpine.js-3.4.2-8BC0D0.svg" alt="Alpine.js">
  <img src="https://img.shields.io/badge/License-MIT-green.svg" alt="License">
</p>

"Monitoreo de inventario en tiempo real"

## 📋 Descripción

StockMaster es una plataforma web moderna y robusta para la gestión de inventario. Diseñada con un enfoque en la experiencia de usuario (UX) y la trazabilidad, permite administrar el flujo de productos desde su entrada hasta su venta final, garantizando que cada movimiento sea auditado con precisión.

## 🚀 Características Destacadas

### Dashboard con Métricas Vivas
Panel de control con indicadores dinámicos y acceso rápido a operaciones críticas.
- Estadísticas de inventario actualizadas en tiempo real
- Gráficos y reportes visuales
- Notificaciones y alertas del sistema

### Log de Actividad con Auditoría
Sistema de monitoreo en tiempo real con indicadores visuales de "Live Status".
- Registro histórico inmutable: guarda el nombre del producto en el momento de la transacción (evita pérdida de datos por cambios de nombre o eliminaciones)
- Identificación visual de movimientos (Entradas/Salidas) mediante códigos de color dinámicos
- Historial detallado con usuario responsable

### Gestión de Stock Avanzada
- Ajustes manuales con motivos (Dañado, Pérdida, Devolución)
- Categorización jerárquica y administración de proveedores
- Entradas y salidas de productos con filtros avanzados

### Autenticación Completa
Sistema de login/registro con Laravel Jetstream.
- Registro de usuarios con verificación de email
- Inicio de sesión seguro
- Restablecimiento de contraseña
- Gestión de perfil de usuario

### Gestión Integral
- **Productos**: Catálogo completo con información detallada, búsqueda y filtrado
- **Categorías**: Organización jerárquica de productos
- **Proveedores**: Administración completa de datos de contacto y contratos
- **Ventas**: Sistema de facturación con cálculos automáticos de totales e impuestos
- **Punto de Venta (POS)**: Sistema completo de ventas con carrito interactivo, búsqueda en tiempo real y validación de stock
- **Fidelización de Clientes**: Sistema de puntos con canje de descuentos, niveles VIP y gestión de clientes

### Interfaz Premium
- Diseño responsivo con Tailwind CSS
- Componentes reactivos con Alpine.js
- Sidebar moderno con identidad de marca integrada
- API REST con Laravel Sanctum

## 🛠️ Tecnologías Utilizadas

### Backend
- **Laravel 12.10**: Framework PHP líder para desarrollo web
- **PHP 8.5**: Lenguaje de programación del servidor
- **Laravel Jetstream**: Autenticación y gestión de usuarios
- **Laravel Sanctum**: Autenticación API segura
- **Eloquent ORM**: Mapeo objeto-relacional para bases de datos

### Frontend
- **Blade Templates**: Motor de plantillas dinámicas de Laravel
- **Tailwind CSS 3.1.0**: Framework CSS utilitario
- **Alpine.js 3.4.2**: Framework JavaScript reactivo
- **Vite 5.0.0**: Herramienta de construcción rápida

### Base de Datos
- **MySQL/PostgreSQL/SQLite**: Soporte para múltiples motores
- **Laravel Migrations**: Control de versiones de esquema

### Testing
- **Pest**: Framework de testing moderno para PHP

## 📦 Instalación

1. **Clona el repositorio:**
   ```bash
   git clone <url-del-repositorio>
   cd admInventario
   ```

2. **Instala las dependencias de PHP:**
   ```bash
   composer install
   ```

3. **Instala las dependencias de Node.js:**
   ```bash
   npm install
   ```

4. **Configura el entorno:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configura la base de datos** en el archivo `.env` y ejecuta:
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Compila los assets:**
   ```bash
   npm run dev
   # o para producción
   npm run build
   ```

7. **Inicia el servidor:**
   ```bash
   php artisan serve
   ```

## 🚀 Despliegue en Producción

### Preparación del Entorno
1. **Configura el archivo `.env`:**
   ```bash
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://tu-dominio.com
   # Configura DB_CONNECTION, DB_HOST, etc. para tu base de datos de producción
   ```

2. **Genera la clave de aplicación:**
   ```bash
   php artisan key:generate
   ```

3. **Ejecuta migraciones y seeders:**
   ```bash
   php artisan migrate --seed
   ```

### Optimización para Producción
1. **Cachea la configuración y rutas:**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **Compila assets para producción:**
   ```bash
   npm run build
   ```

3. **Enlaza el almacenamiento público:**
   ```bash
   php artisan storage:link
   ```

### Verificación Pre-Despliegue
- Ejecuta pruebas: `php artisan test`
- Verifica permisos de archivos (storage/ debe ser writable)
- Asegura que el servidor web (Apache/Nginx) esté configurado correctamente
- Configura SSL/HTTPS

### Monitoreo en Producción
- Revisa logs en `storage/logs/laravel.log`
- Monitorea rendimiento con herramientas como Laravel Telescope (opcional)
- Configura backups automáticos de la base de datos

## 🗄️ Estructura de Auditoría (Base de Datos)

El corazón del sistema es la tabla de movimientos, diseñada para la seguridad del inventario:

- **user_id**: Responsable de la acción
- **producto_nombre**: Respaldo de texto del nombre (Auditoría segura)
- **cantidad**: Cantidades positivas (Entradas) y negativas (Salidas)
- **color_badge**: Metadata visual para la interfaz

Otras tablas principales:
- **users**: Usuarios del sistema
- **categorias**: Categorías de productos
- **proveedores**: Información de proveedores
- **productos**: Catálogo de productos
- **ventas**: Ventas realizadas con detalles
- **detalle_ventas**: Detalles específicos de cada venta

## 🧪 Ejecutar Pruebas

```bash
php artisan test
```

## 📝 Uso

1. Accede a la aplicación en tu navegador
2. Registra una cuenta o inicia sesión
3. Gestiona categorías, proveedores, productos, movimientos de inventario y ventas desde el dashboard
4. Monitorea el inventario en tiempo real desde el panel de métricas

## 🤝 Contribución

Si deseas contribuir, por favor abre un Pull Request detallando los cambios. Toda mejora en la eficiencia del inventario es bienvenida.

## 📄 Licencia

Este proyecto está bajo la Licencia MIT.
