<?php

use App\Models\Event;
use App\Models\Liver;
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
        Schema::create('event_liver', function (Blueprint $table) {
            $table->foreignIdFor(Event::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Liver::class)->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_event_livers');
    }
};
