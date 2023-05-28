<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('users', function (Blueprint $table) {

      $table->date('dob')->after('role')->nullable();
      $table->string('image', 3000)->after('dob')->nullable();
      $table->string('gender')->after('image')->nullable();
      $table->string('designation')->after('gender')->nullable();
      $table->boolean('is_manager')->after('designation')->default(0)->nullable();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      //
    });
  }
};
