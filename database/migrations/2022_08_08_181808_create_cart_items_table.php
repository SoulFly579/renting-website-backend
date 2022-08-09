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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId("session_id")->constrained("shopping_sessions")->cascadeOnDelete();
            $table->foreignId("product_id")->constrained("products")->cascadeOnDelete();
            $table->foreignId("variant_id")->nullable()->constrained("product_variant_values")->cascadeOnDelete();
            $table->integer("quantity")->default(1);
            $table->foreignId("rent_time_id")->constrained("rent_times")->cascadeOnDelete();
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
        Schema::dropIfExists('cart_items');
    }
};
