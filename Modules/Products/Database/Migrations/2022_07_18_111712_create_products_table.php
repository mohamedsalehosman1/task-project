<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Addresses\Entities\Region;
use Modules\Services\Entities\Service;
use Modules\Vendors\Entities\Vendor;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Vendor::class)->constrained()->cascadeOnDelete();
          

            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('price', 10, 2)->nullable();

            $table->boolean('has_quantity_limit')->nullable()->default(false)->comment('يحدد ما إذا كان المنتج يُباع كقطع أو له قيود كمية');

            $table->unsignedInteger('max_amount')->nullable();

            $table->time('base_preparation_time')->nullable();
            $table->enum('status', ['pending', 'accepeted', 'rejected'])->default('pending');
            $table->enum('pay_type', ['in_app', 'out_app'])->default('out_app');

            $table->boolean('active')->nullable()->default(true);

            $table->json('working_hours')->nullable();
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
        Schema::dropIfExists('products');
    }
}
