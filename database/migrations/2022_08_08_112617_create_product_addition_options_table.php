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
        Schema::create('product_addition_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId("addition_group_id")->constrained("product_addition_groups")->cascadeOnDelete();
            $table->string("name");
            $table->decimal("price");
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
        Schema::dropIfExists('product_addition_options');
    }
};
