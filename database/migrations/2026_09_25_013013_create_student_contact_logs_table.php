<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_contact_logs', function (Blueprint $table) {
            $table->id();
            $table->string('old_email')->nullable();
            $table->string('new_email')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_contact_logs');
    }
};
