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
        Schema::create('admission_requests', function (Blueprint $table) {
            $table->id();
            $table->string('application_id')->unique();
            $table->string('full_name');
            $table->string('father_name');
            $table->string('cnic', 20)->nullable();
            $table->date('dob')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('nationality', 50)->nullable();
            $table->string('religion', 50)->nullable();
            $table->string('blood_group', 10)->nullable();
            $table->string('mobile', 20);
            $table->string('whatsapp', 20)->nullable();
            $table->string('email');
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('class_applying');
            $table->string('academic_part', 50)->nullable();
            $table->string('prev_school')->nullable();
            $table->string('prev_board')->nullable();
            $table->string('prev_roll_no', 20)->nullable();
            $table->decimal('marks_obtained', 8, 2)->nullable();
            $table->decimal('total_marks', 8, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->string('voucher_id')->nullable();
            $table->string('payment_status')->default('Unpaid');
            $table->string('status')->default('Pending Review');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_requests');
    }
};
