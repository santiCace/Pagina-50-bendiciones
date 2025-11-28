# 📘 Mi Aplicación PHP - MySQL

Una aplicación web simple desarrollada en PHP 7 para gestionar usuarios con operaciones básicas de base de datos (CRUD).

## 🚀 Características

- ✨ **Agregar usuarios**: Formulario completo con validaciones
- 📋 **Consultar usuarios**: Lista paginada con búsqueda
- 🗑️ **Eliminar usuarios**: Eliminación segura con confirmación
- 🔍 **Búsqueda**: Buscar por nombre o email
- 🎨 **Interfaz moderna**: Diseño responsive y atractivo
- 🔒 **Seguridad**: Prepared statements para prevenir SQL injection

## 📋 Requisitos

- **XAMPP** (Apache + PHP 7+ + MySQL)
- **PHP 7.0** o superior
- **MySQL 5.7** o superior
- Navegador web moderno

## 🛠️ Instalación

### 1. Preparar XAMPP
1. Instala XAMPP si no lo tienes
2. Inicia Apache y MySQL desde el panel de control de XAMPP
3. Verifica que los servicios estén corriendo

### 2. Configurar el proyecto
1. ✅ **Proyecto ya configurado** en la carpeta `htdocs` de XAMPP:
   ```
   C:\xampp\htdocs\serverphp\
   ```

2. Accede desde el navegador:
   ```
   http://localhost/serverphp/
   ```

### 3. Base de datos (Automática)
La aplicación creará automáticamente:
- Base de datos: `mi_aplicacion`
- Tabla: `usuarios` con la estructura necesaria

## 📁 Estructura del proyecto

```
serverphp/
├── config/
│   └── database.php          # Configuración de BD
├── css/
│   └── style.css            # Estilos CSS
├── index.php               # Página principal
├── agregar.php             # Formulario para agregar usuarios
├── usuarios.php            # Lista y consulta de usuarios
└── README.md              # Esta documentación
```

## ⚙️ Configuración

### Base de datos
Edita `config/database.php` si necesitas cambiar la configuración:

```php
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');        // En XAMPP suele estar vacía
define('DB_DATABASE', 'mi_aplicacion');
define('DB_PORT', '3306');
```

## 🎯 Uso de la aplicación

### Navegación principal
- **Inicio**: Página de bienvenida con información del sistema
- **Ver Usuarios**: Lista completa con búsqueda y eliminación
- **Agregar Usuario**: Formulario para nuevos registros

### Agregar usuarios
1. Ve a "Agregar Usuario"
2. Completa los campos obligatorios (nombre y email)
3. Opcionalmente agrega un teléfono
4. Haz clic en "Guardar Usuario"

### Consultar usuarios
1. Ve a "Ver Usuarios"
2. Usa el buscador para filtrar por nombre o email
3. Ve todos los detalles en la tabla

### Eliminar usuarios
1. En la lista de usuarios, haz clic en "Eliminar"
2. Confirma la acción en el diálogo
3. El usuario será eliminado permanentemente

## 🔧 Características técnicas

### Seguridad implementada
- **Prepared Statements**: Previene inyección SQL
- **Validación de datos**: Sanitización de entradas
- **Confirmación de eliminación**: Previene borrados accidentales
- **Escape de HTML**: Previene XSS básico

### Base de datos
```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## 🎨 Funciones destacadas

### Responsive Design
- Adaptado para móviles y tablets
- Interfaz moderna con gradientes
- Iconos descriptivos

### Validaciones
- Email único (no duplicados)
- Formato de email válido
- Campos obligatorios marcados
- Mensajes informativos

### Búsqueda avanzada
- Búsqueda en tiempo real
- Filtro por nombre o email
- Conteo de resultados

## 🚨 Solución de problemas

### Error de conexión a MySQL
1. Verifica que MySQL esté corriendo en XAMPP
2. Comprueba las credenciales en `config/database.php`
3. Asegúrate de que el puerto 3306 esté disponible

### Página en blanco
1. Activa la visualización de errores PHP
2. Revisa los logs de Apache en XAMPP
3. Verifica que PHP esté funcionando correctamente

### Error "Table doesn't exist"
1. La aplicación debería crear la tabla automáticamente
2. Si persiste, ejecuta manualmente el SQL desde phpMyAdmin
3. Verifica permisos de la base de datos

## 📈 Posibles mejoras

- [ ] Editar usuarios existentes
- [ ] Sistema de autenticación
- [ ] Paginación de resultados
- [ ] Exportar datos a CSV/Excel
- [ ] Validaciones más robustas
- [ ] Sistema de logs
- [ ] API REST

## 📝 Licencia

Este proyecto es de código abierto y está diseñado para fines educativos.

## 👨‍💻 Desarrollador

Desarrollado para aprendizaje de PHP y MySQL con XAMPP.

---

**¡Listo para usar!** 🎉

Simplemente inicia XAMPP, copia los archivos y accede desde tu navegador.