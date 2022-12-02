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
        Schema::create('note_alignment_masters', function (Blueprint $table) {
          $table->id();
          $table->uuid('uuid')->unique();
          $table->integer('note_template_master_id')->unsigned();

          $table->string('name');
          $table->longtext('note_uri')->nullable();
          
          $table->timestamps();
          $table->integer('created_by')->default(0);
          $table->integer('updated_by')->default(0);
          $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('note_alignment_masters');
    }
};
