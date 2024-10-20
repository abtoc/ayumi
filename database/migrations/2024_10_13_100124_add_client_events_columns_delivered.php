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
        Schema::table('client_events', function (Blueprint $table) {
            $table->boolean('delivered')->default(false)->after('account_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('client_events', function (Blueprint $table) {
            $table->dropColumn('delivered');
        });
    }
};
