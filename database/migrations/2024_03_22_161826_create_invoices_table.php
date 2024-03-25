<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();

            // Your Company Information
            $table->string('company_name')->nullable();
            $table->text('company_address')->nullable();
            $table->string('company_phone')->nullable();

            // Invoice Dates
            $table->date('invoice_date');
            $table->date('due_date');

            // Invoice To (Customer/Bidder)
            $table->string('invoice_to_name')->nullable();
            $table->string('invoice_to_company_name')->nullable();
            $table->text('invoice_to_address')->nullable();
            $table->string('invoice_to_phone')->nullable();
            $table->string('invoice_to_email')->nullable();

            // Consider adding a foreign key if billing a different entity
            // $table->foreignId('bill_to_id')->nullable()->constrained();

            // Invoice Items (We'll discuss this shortly)
            $table->decimal('tax', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->decimal('total', 10, 2);
            $table->foreignId('bid_id')->constrained('lms_g49_bids');
            $table->text('notes')->nullable();
            $table->json('items');

            //Locked PDF
            //$table->boolean('is_pdf_generated')->default(false);

            //Payment Something
            $table->decimal('amount_paid', 10, 2)->default(0.00);
            $table->decimal('balance', 10, 2)->default(0.00);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};
