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
        // Storing/displaying the plaintext password permanently was a
        // security issue (full password exposure on any DB or backup leak).
        // Dropping the column also erases the plaintext values already on
        // disk for existing users.
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('initial_password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('initial_password')->nullable()->after('password');
        });
    }
};
