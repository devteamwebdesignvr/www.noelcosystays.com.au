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
        Schema::create('host_away_calcelation_policies', function (Blueprint $table) {
            $table->id();
             $table->string("host_away_id")->nullable();
            $table->string("accountId")->nullable();
            $table->string("name")->nullable();
            $table->longText("cancellationPolicyItem")->nullable();

            
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
        Schema::dropIfExists('host_away_calcelation_policies');
    }
};
