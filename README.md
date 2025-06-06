<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Laravel APP

Este proyecto es una aplicacion  web para gestionar tareas, construida con laravel como backend y Mysql como base d datos incluye el uso de procedimientos almacenados. Requerimientos de Instalacion

- PHP
- Composer
- Mysql
- Laragon
- Visual Code
- Node.js
- Git
- Postman

## Alojamiento web

Se utilizo como alojamiento web Railway. 

## Ejecutar la aplicacion local

Pasos:

- composer install
- php aritsan migrate(despues de haber configurado todas las tablas necesarias)
- php artisan serve

## Uso de procedimientos almacenados

Los procedimientos almacenados fueron creados desde la configuracion de las tablas antes de ejecutar el comando php aritsan mirgrate.
Ejemplo de procedimiento almacenado usado en la creacion de la tareas:

DB::unprepared("
            DROP PROCEDURE IF EXISTS insertarTarea;
            CREATE PROCEDURE insertarTarea (
                IN p_titulo VARCHAR(255),
                IN p_descripcion TEXT,
                IN p_fecha_limite DATE,
                IN p_user_id BIGINT
            )
            BEGIN
                INSERT INTO tareas (titulo, descripcion, fecha_limite, user_id)
                VALUES (p_titulo, p_descripcion, p_fecha_limite, p_user_id);
                SELECT * FROM tareas WHERE id = LAST_INSERT_ID();
            END;
            
        ");


  

