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
        Schema::create('note_template_masters', function (Blueprint $table) {
          $table->id();
          $table->uuid('uuid')->unique();

          $table->string('name');
          $table->longtext('template_id');
          $table->longtext('folder_uri');
          $table->longtext('recordset_model')->nullable();
          $table->longtext('recordset_page_template_id')->nullable();
          $table->longtext('recordset_tagname_space')->nullable();
          
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
        Schema::dropIfExists('note_template_masters');
    }
};
