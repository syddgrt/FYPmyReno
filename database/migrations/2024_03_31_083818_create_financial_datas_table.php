<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFinancialDatasTable extends Migration
{
    public function up()
    {
        Schema::create('financial_datas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->index(); // Assuming you have a clients table
            $table->unsignedBigInteger('designer_id')->index(); // Assuming you have a designers table
            $table->string('type'); // Could be 'expense', 'income', etc.
            $table->decimal('amount', 10, 2); // Example amount with 2 decimal places
            $table->text('description')->nullable(); // Description of the transaction
            $table->date('date'); // The date of the transaction
            $table->timestamps();

            // Foreign keys setup if needed
            // $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            // $table->foreign('designer_id')->references('id')->on('designers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_datas');
    }
}

