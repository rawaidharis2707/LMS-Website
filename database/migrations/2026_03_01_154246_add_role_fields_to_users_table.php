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
            $table->string('role', 20)->nullable()->after('email');
            $table->string('enrolled_class', 50)->nullable()->after('role');
            $table->foreignId('school_class_id')->nullable()->constrained('school_classes')->onDelete('set null')->after('enrolled_class');
            $table->string('roll_number', 50)->nullable()->after('school_class_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropColumn(['role', 'enrolled_class', 'school_class_id', 'roll_number']);
        });
    }
};
