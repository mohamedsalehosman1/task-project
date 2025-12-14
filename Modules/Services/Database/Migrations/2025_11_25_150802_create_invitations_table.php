<?php

// database/migrations/..._create_invitations_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الهجرة (Run the migrations).
     */
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('event_type', 50)->nullable()->comment('نوع الحدث: زفاف، خطوبة، إلخ.');
            $table->string('groom_name', 100)->nullable();
            $table->string('bride_name', 100)->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->text('location_text')->nullable()->comment('عنوان المكان كنص');
            $table->string('location_url')->nullable()->comment('رابط موقع الخريطة');
            $table->text('quran_verse')->nullable()->comment('الآية الكريمة أو المقطع');
            $table->text('invitation_text')->nullable()->comment('نص الدعوة النهائي');

            $table->enum('status', ['draft', 'active', 'archived'])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * التراجع عن الهجرة (Reverse the migrations).
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};
