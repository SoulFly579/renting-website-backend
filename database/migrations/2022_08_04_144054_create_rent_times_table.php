<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rent_times', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("product_id")->constrained("products")->cascadeOnDelete();
            $table->integer("amount_of_time");
            $table->string("type_of_period");
            $table->decimal("cost");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rent_times');
    }
};
