<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserProductTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_product_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_product_id');
            $table->string('name');
            $table->string('company_name');
            $table->string('user_service_name');
            $table->string('admin_reply')->nullable();
            $table->text('description');
            $table->string('locale')->index();
            $table->unique(['user_product_id', 'locale']);
            $table->foreign('user_product_id')->references('id')->on('user_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_product_translations');
    }
}
