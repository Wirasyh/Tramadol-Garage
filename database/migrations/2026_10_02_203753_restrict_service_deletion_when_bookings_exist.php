<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table): void {
            $table->dropForeign(['service_id']);
        });

        Schema::table('bookings', function (Blueprint $table): void {
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table): void {
            $table->dropForeign(['service_id']);
        });

        Schema::table('bookings', function (Blueprint $table): void {
            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->cascadeOnDelete();
        });
    }
};
