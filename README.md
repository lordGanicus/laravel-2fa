# Sistema de Gestión de Relaciones 2fa - Laravel + Inertia + React
---------------Tiene el segundo factor de autenticacion --------------

Este proyecto es una implementación completa de **tres tipos de relaciones de bases de datos** en Laravel, usando **Inertia.js + React** como frontend.  
Incluye ejemplos prácticos de relaciones 1:1, 1:N y N:N con datos de prueba y documentación completa.

---

## 🚀 Tecnologías utilizadas

- **Laravel** 12+
- **Inertia.js**
- **React 19**
- **TailwindCSS**
- **PHP 8+**
- **MySQL**
- **Vite**

---

## 📦 Instalación

Sigue estos pasos para instalar y ejecutar este proyecto en tu máquina local:

### 🔧 1. Clonar el repositorio
```bash
git clone https://github.com/lordGanicus/laravel-2fa.git
cd laravel-2fa


📥 2. Instalar dependencias de PHP
composer install

📥 3. Instalar dependencias de Node
npm install

⚙️ 4. Crear archivo .env
cp .env.example .env

🗄️ 5. Configurar base de datos

En tu archivo .env, configura:

DB_DATABASE=laravel2fa
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password

🛠 6. Ejecutar migraciones
php artisan migrate


🔐 Características del sistema 2FA

Activar o desactivar 2FA por usuario

Generación de códigos QR

Generación de Recovery Codes

Validación de códigos TOTP

Middleware protegido con 2FA

Inertia + React como capa de frontend

Ejecutar el servidor y en el front

composer dev

🧑 Autor

lordGanicus
📧 ribertxdxd@gmail.com
🌐 GitHub
