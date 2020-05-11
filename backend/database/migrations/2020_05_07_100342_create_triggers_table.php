<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('triggers', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('watcher_id');
            $table->foreign('watcher_id')
                ->references('id')
                ->on('watchers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->bigInteger('trigger_type_id');
            $table->foreign('trigger_type_id')
                ->references('id')
                ->on('trigger_types')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->string('value_to_match');
            $table->boolean('is_enabled')
                ->default(true);

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
        Schema::dropIfExists('triggers');
    }
}
