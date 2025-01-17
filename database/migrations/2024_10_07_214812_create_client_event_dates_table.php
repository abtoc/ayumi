<?php

use App\Models\ClientEvent;
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
        Schema::create('client_event_dates', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignIdFor(ClientEvent::class)
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_event_dates');
    }
};
