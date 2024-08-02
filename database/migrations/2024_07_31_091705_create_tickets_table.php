<?php

use App\Models\TicketType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TicketType::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string("banner")->nullable();
            $table->string("eventName");
            $table->string("eventVenue");
            $table->double("price");
            $table->string("ageRestriction")->nullable();
            $table->date("eventDate");
            $table->dateTime("startTime");
            $table->dateTime("endTime");
            $table->string("entrance")->nullable();
            $table->boolean("status")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
