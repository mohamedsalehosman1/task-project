<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Accounts\Entities\User;
use Modules\Addresses\Entities\Region;
use Modules\Categories\Entities\Category;
use Modules\Services\Entities\Service;

class CreateUserProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_products', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->foreignIdFor(Category::class)->constrained()->cascadeOnDelete();
            $table->string('phone');
            $table->string('nationality');
$table->boolean('available')->nullable()->default(true);

            $table->enum('status', ['pending', 'accepeted', 'rejected'])->default('pending');
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
        Schema::dropIfExists('user_products');
    }
}
