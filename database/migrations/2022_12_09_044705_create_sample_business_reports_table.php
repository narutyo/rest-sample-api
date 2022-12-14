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
        Schema::create('sample_business_reports', function (Blueprint $table) {
          $table->id();
          $table->uuid('uuid')->unique();

          $table->string('reportId')->nullable();
          $table->longtext('name')->nullable();
          $table->longtext('customer')->nullable();
          $table->datetime('visitDateTime')->nullable();
          $table->datetime('nextDateTime')->nullable();
          $table->longtext('status')->nullable();
          $table->integer('rank')->default(0);
          $table->longtext('details')->nullable();
          
          $table->string('_driveId')->nullable();
          $table->string('_documentId')->nullable();
          $table->string('_objectType')->nullable();
          $table->string('_objectId')->nullable();
          $table->string('_pageId')->nullable();
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
        Schema::dropIfExists('sample_business_reports');
    }
};
