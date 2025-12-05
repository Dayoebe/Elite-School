<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Schools table
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('initials')->nullable();
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('code');
            $table->string('logo_path')->nullable();
            $table->foreignId('academic_year_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->foreignId('semester_id')->nullable()->constrained()->onDelete('set null')->onUpdate('set null');
            $table->timestamps();
        });

        // Class Groups table
        Schema::create('class_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('school_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['school_id', 'name']);
        });

        // My Classes table
        Schema::create('my_classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('class_group_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();
            $table->timestamps();
            $table->unique(['class_group_id', 'name']);
        });

        // Sections table
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('my_class_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->unique(['name', 'my_class_id']);
        });

        // Grade Systems table
        Schema::create('grade_systems', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('remark')->nullable();
            $table->string('grade_from');
            $table->string('grade_till');
            $table->foreignId('class_group_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_systems');
        Schema::dropIfExists('sections');
        Schema::dropIfExists('my_classes');
        Schema::dropIfExists('class_groups');
        Schema::dropIfExists('schools');
    }
};