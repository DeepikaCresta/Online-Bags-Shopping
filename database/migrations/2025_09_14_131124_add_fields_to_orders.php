<?php

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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('session_id');

            $table->string('order_tracking_id')->nullable()->before('total');
            $table->string('payment_type')->nullable()->before('total');
            $table->decimal('tax', 10, 2)->nullable()->before('total');
            $table->decimal('subtotal', 10, 2)->nullable()->before('total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('session_id')->nullable();

            $table->dropColumn([
                'order_tracking_id',
                'payment_type',
                'tax',
                'subtotal',
            ]);
        });
    }
};
