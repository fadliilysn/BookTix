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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_code');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_code', 255)->unique()->after('id');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('ticket_code');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->string('ticket_code', 255)->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('order_code');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->uuid('order_code')->unique()->after('id');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('ticket_code');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->uuid('ticket_code')->unique()->after('id');
        });
    }
};
