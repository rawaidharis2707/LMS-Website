<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admission_requests', function (Blueprint $table) {
            $table->string('photo_path')->nullable();
            $table->string('fee_receipt_path')->nullable();
            $table->string('doc_student_cnic_path')->nullable();
            $table->string('doc_guardian_cnic_path')->nullable();
            $table->string('doc_result_card_path')->nullable();
            $table->string('doc_character_cert_path')->nullable();
            $table->string('doc_domicile_path')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('admission_requests', function (Blueprint $table) {
            $table->dropColumn([
                'photo_path',
                'fee_receipt_path',
                'doc_student_cnic_path',
                'doc_guardian_cnic_path',
                'doc_result_card_path',
                'doc_character_cert_path',
                'doc_domicile_path',
            ]);
        });
    }
};
