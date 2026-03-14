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
        Schema::table('creator_profiles', function (Blueprint $table) {
            //
            $table->string('goal_title')->nullable()->after('is_onboarded');
            $table->integer('goal_amount')->nullable()->after('goal_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('creator_profiles', function (Blueprint $table) {
            //
            $table->dropColumn(['goal_title', 'goal_amount']);
        });
    }
};
