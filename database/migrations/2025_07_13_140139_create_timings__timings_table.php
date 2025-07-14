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
	    Schema::create('timings__timings', function (Blueprint $table) {
		    $table->id();

		    $table->unsignedBigInteger('parent_id')->nullable();
		    $table->foreign('parent_id')->references('id')->on('timings__timings');

		    $table->nullableUuidMorphs('timeable');

		    $table->text('parameters')->nullable();

		    $table->unsignedBigInteger('quantity_required')->nullable();
		    $table->decimal('seconds', 12, 4)->nullable();

		    $table->string('type',12)->nullable();

		    $table->softDeletes();
		    $table->timestamps();
	    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timings__timings');
    }
};
