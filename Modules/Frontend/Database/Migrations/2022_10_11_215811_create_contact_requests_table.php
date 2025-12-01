<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\HowKnow\Entities\Reason;

class CreateContactRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string("exhibition", 191);
            $table->string("name", 191);
            $table->string("nationality", 191)->nullable();
            $table->string("email", 191);
            $table->string("phone_number", 191)->nullable();
            $table->string("profession")->nullable();
            $table->string("reference_num")->nullable();
            // $table->foreignIdFor(Reason::class)->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('contact_requests');
    }
}
