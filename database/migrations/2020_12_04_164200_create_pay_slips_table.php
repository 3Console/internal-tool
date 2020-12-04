<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaySlipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_slips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('working_hours');
            $table->unsignedInteger('absence_hours');
            $table->unsignedInteger('overtime_hours');
            $table->unsignedInteger('late_hours');
            $table->unsignedInteger('support_amount');
            $table->unsignedInteger('bonus_amount');
            $table->unsignedInteger('violation_amount');
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
        Schema::dropIfExists('pay_slips');
    }
}
