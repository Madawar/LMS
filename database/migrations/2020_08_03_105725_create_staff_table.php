<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('staff');
            $table->string('pno')->unique()->nullable();
            $table->string('role')->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->bigInteger('department')->nullable();
            $table->double('leave_days')->default(0);
            $table->date('dateOfEmployment');
            $table->string('workingDays')->nullable();
            $table->double('leaveIncrements')->nullable();
            $table->boolean('shiftEmployee')->default(0);
            $table->boolean('detailsVerified')->default(0);
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
        Schema::dropIfExists('staff');
    }
}
