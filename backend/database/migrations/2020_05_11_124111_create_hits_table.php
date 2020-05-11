<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hits', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('scan_id');
            $table->foreign('scan_id')
                ->references('id')
                ->on('scans')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->bigInteger('trigger_id')
                ->nullable();
            $table->foreign('trigger_id')
                ->references('id')
                ->on('triggers')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->bigInteger('trigger_type_id')
                ->nullable();
            $table->foreign('trigger_type_id')
                ->references('id')
                ->on('trigger_types')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->string('trigger_value');

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
        Schema::dropIfExists('hits');
    }
}
