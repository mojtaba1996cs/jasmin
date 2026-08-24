<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->default(2);
            }

            if (!Schema::hasColumn('users', 'office_id')) {
                $table->unsignedBigInteger('office_id')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropColumn('role_id');
            }

            if (Schema::hasColumn('users', 'office_id')) {
                $table->dropColumn('office_id');
            }

        });
    }
};