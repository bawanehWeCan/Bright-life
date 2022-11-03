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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('supplier_id')->constrained('users','id')->cascadeOnDelete();
            $table->enum('status',['Pending','On Delivery','Complete','Cancel']);
            $table->enum('payment_method',['Cash','Credit']);
            $table->text('note');
            $table->text('type')->nullable();
            $table->text('lat')->nullable();
            $table->text('long')->nullable();
            $table->double('total');
            $table->double('tax');
            $table->double('delivery_fee');
            $table->double('discount');
            $table->double('percentage');
            $table->double('order_value');
            $table->string('number')->unique();
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
        Schema::dropIfExists('orders');
    }
};
