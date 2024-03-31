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
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade'); // Link to projects
            $table->string('type'); // Could be 'expense', 'income', etc., or more detailed depending on your project structure
            $table->decimal('cost_estimation', 10, 2); // Estimated cost
            $table->decimal('actual_cost', 10, 2)->nullable(); // Actual cost incurred
            $table->decimal('tax', 10, 2)->nullable(); // Tax applied
            $table->decimal('additional_fees', 10, 2)->nullable(); // Any additional fees
            $table->text('description')->nullable(); // Description of the transaction
            $table->date('date'); // The date of the transaction or cost estimation
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('financial_datas');
    }
}


