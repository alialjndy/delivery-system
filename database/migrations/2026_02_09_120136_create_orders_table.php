<?php

use Brick\Math\BigInteger;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('driver_id')->nullable()->constrained('drivers')->nullOnDelete();

            $table->decimal('pickup_lat', 10, 8);
            $table->decimal('pickup_lng', 11, 8);

            $table->decimal('dropoff_lat', 10, 8);
            $table->decimal('dropoff_lng', 11, 8);

            // هنا يمكن أن نجعل نوع السطر هو string
            // ونقوم بعمليات التحقق ضمن الدومين أي هناك نقوم باستخدام Enum
            $table->enum('status',['created','confirmed','cancelled','in_progress','delivered'])->default('created');

            $table->bigInteger('cost')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
