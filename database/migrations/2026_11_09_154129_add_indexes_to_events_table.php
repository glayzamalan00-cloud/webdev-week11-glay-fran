<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kaya ng Schema builder
        Schema::table('events', function (Blueprint $table) {
            $table->fullText('description');
        });

        // Hindi kaya ng Schema builder, kaya raw SQL
        DB::statement("CREATE INDEX events_details_gin ON events USING GIN (details jsonb_path_ops)");
        DB::statement("CREATE INDEX events_dress_code_idx ON events ((details->>'dress_code'))");
    }

    public function down(): void
    {
        DB::statement("DROP INDEX IF EXISTS events_dress_code_idx");
        DB::statement("DROP INDEX IF EXISTS events_details_gin");

        Schema::table('events', function (Blueprint $table) {
            $table->dropFullText(['description']);
        });
    }
};