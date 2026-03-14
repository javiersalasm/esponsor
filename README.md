# ☕ Soportify - Plataforma de Apoyo para Creadores

![Laravel](https://img.shields.io/badge/Laravel_11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Vue.js](https://img.shields.io/badge/Vue_3-4FC08D?style=for-the-badge&logo=vue.js&logoColor=white)
![Inertia.js](https://img.shields.io/badge/Inertia.js-9553E9?style=for-the-badge&logo=inertia&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

Soportify es una mini plataforma full-stack desarrollada como solución al **Desafío Técnico de eSponsor**. Permite a los creadores de contenido configurar una página pública, gestionar sus enlaces y recibir apoyos financieros simbólicos de su comunidad.

---

## 🚀 Requisitos Previos

Asegúrate de tener instalado en tu entorno local:
* [PHP](https://www.php.net/) >= 8.2
* [Composer](https://getcomposer.org/)
* [Node.js](https://nodejs.org/) (v18 o superior) y NPM

---

## 🛠️ Instalación y Configuración

Sigue estos pasos para levantar el entorno de desarrollo local:

### 1. Clonar el repositorio y dependencias
```bash
git clone [https://github.com/javiersalasm/esponsor.git](https://github.com/javiersalasm/esponsor.git)
cd esponsor

# Instalar dependencias de PHP
composer install

# Instalar dependencias de Node.js
npm install
```

### 2. Configuración del Entorno (.env)
Copia el archivo de ejemplo para crear tu configuración local:
```bash
cp .env.example .env
```
Genera la clave de la aplicación:
```bash
php artisan key:generate
```

### 3. Base de Datos y Migraciones
Por defecto en Laravel 11, puedes usar SQLite para un entorno de pruebas rápido. Si prefieres MySQL o PostgreSQL, actualiza las credenciales en tu `.env`.

Ejecuta las migraciones para crear las tablas:
```bash
php artisan migrate
```

### 4. Enlace de Almacenamiento (¡Importante! ⚠️)
Para que los avatares subidos por los usuarios sean visibles públicamente, debes crear el enlace simbólico hacia la carpeta `storage/app/public`:
```bash
php artisan storage:link
```

---

## 💻 Ejecución del Proyecto

Este proyecto utiliza Laravel en el backend y Vite para compilar los assets de Vue en el frontend. **Necesitarás mantener dos terminales abiertas simultáneamente.**

**Terminal 1 (Servidor Backend):**
```bash
php artisan serve
```
*(El servidor se iniciará en `http://localhost:8000`)*

**Terminal 2 (Servidor de Desarrollo Frontend / Vite):**
```bash
npm run dev
```
*(Este proceso vigilará los cambios en los archivos `.vue` y aplicará Hot Module Replacement)*

¡Listo! Ya puedes acceder a la aplicación desde tu navegador en `http://localhost:8000`.

---

## 👨‍💻 Autor

**Javier Ignacio Salas Mardones**