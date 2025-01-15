<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('student_id')->unique();
            $table->string('year_section');
            $table->string('program');
            $table->string('name');
            $table->enum('gender', ['male', 'female', 'other', 'prefer-not-to-say']);
            $table->date('birthday')->nullable();
            $table->string('contact');
            $table->string('password'); // Hashed password
            $table->timestamps();
        });

        // Add constraints using raw SQL
        DB::statement("
            ALTER TABLE students
            ADD CONSTRAINT chk_student_id_format
            CHECK (student_id LIKE '[0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9][0-9]-[A-Z][A-Z]-[0-9]');
        ");

        DB::statement("
            ALTER TABLE students
            ADD CONSTRAINT chk_year_section_format
            CHECK (year_section LIKE '[1-4]-[1-5]');
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
}
