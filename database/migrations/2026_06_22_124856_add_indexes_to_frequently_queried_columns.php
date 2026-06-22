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
        Schema::table('events', function (Blueprint $table) {
            $table->index('slug');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->index('order_code');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->index('ticket_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['slug']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['order_code']);
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropIndex(['ticket_code']);
        });
    }
};
