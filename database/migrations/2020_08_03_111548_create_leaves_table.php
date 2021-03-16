<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('staff_id')->unsigned();
            $table->date('startDate');
            $table->date('endDate');
            $table->string('leaveType');
            $table->double('calculatedDays')->nullable();
            $table->double('amendedDays')->nullable();
            $table->boolean('finalized')->nullable();
            $table->boolean('hr_finalized')->nullable();
            $table->boolean('cancelled')->nullable();
            $table->foreign('staff_id')
                ->references('id')->on('staff')
                ->onDelete('cascade');
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
        Schema::dropIfExists('leaves');
    }
}
