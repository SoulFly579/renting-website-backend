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
        Schema::create('cart_item_additions', function (Blueprint $table) {
            $table->id();
            $table->foreignId("cart_item_id")->constrained("cart_items")->cascadeOnDelete();
            $table->foreignId("option_id")->constrained("product_addition_options")->cascadeOnDelete();
            $table->foreignId("addition_id")->constrained("product_addition_groups")->cascadeOnDelete();
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
        Schema::dropIfExists('cart_item_additions');
    }
};
