<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lead_transfer_requests', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('lead_id')->nullable();

            $table->string('lead_name')->nullable();

            $table->string('lead_mobile')->nullable();

            $table->string('current_counselor_name')->nullable();

            $table->unsignedBigInteger('requested_by_id')->nullable();

            $table->string('requested_by_name')->nullable();

            $table->string('requested_branch')->nullable();

            $table->string('status')
                ->default('Pending');

            $table->text('rejection_reason')
                ->nullable();

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'lead_transfer_requests'
        );
    }
};
