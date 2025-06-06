<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tareas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->date('fecha_limite');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamps();
        });

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

        DB::unprepared("
            DROP PROCEDURE IF EXISTS eliminarTarea;
            CREATE PROCEDURE eliminarTarea (
                IN p_id BIGINT
            )
            BEGIN
                DELETE FROM tareas WHERE id = p_id;
            END;
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas');
        DB::unprepared("DROP PROCEDURE IF EXISTS insertarTarea;");
        DB::unprepared("DROP PROCEDURE IF EXISTS eliminarTarea;");
    }
};
