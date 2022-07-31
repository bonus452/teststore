<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propertables', function (Blueprint $table) {
            $table->unsignedBigInteger('propertable_id');
            $table->string('propertable_type');
            $table->unsignedBigInteger('property_value_id');

            $table->foreign('property_value_id')->references('id')->on('property_values')->cascadeOnDelete();
            $table->primary(['propertable_id', 'propertable_type', 'property_value_id'], 'prop_id_type_val_foreign');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propertables');
    }
}
