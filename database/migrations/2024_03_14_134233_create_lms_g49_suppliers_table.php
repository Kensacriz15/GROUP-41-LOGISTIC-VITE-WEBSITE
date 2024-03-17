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
        Schema::create('lms_g49_suppliers', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('supplier_id')->nullable();
          $table->string('supplier_name', 255);
          $table->string('Address', 255);
          $table->string('city', 100);
          $table->string('zip_code', 20);
          $table->string('contact_name', 255);
          $table->string('Email', 255);
          $table->string('Phone', 20);
          $table->enum('Status', ['active', 'inactive']);
          $table->timestamps();
      });
      }

      /**
       * Reverse the migrations.
       */
      public function down(): void
      {
          Schema::dropIfExists('lms_g49_suppliers');
      }
  };
