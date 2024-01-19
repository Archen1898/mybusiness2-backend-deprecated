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
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropIndex('oauth_access_tokens_user_id_index'); //
            $table->uuid('user_id')->nullable(false)->change();

            // Vuelve a crear el índice o crea uno nuevo si es necesario
            // $table->index('user_id'); // Crea un nuevo índice si es necesario
        });
//        Schema::table('oauth_access_tokens', function (Blueprint $table) {
//            $table->uuid('user_id')->change();
//            $table->uuid('client_id')->nullable()->change();
//        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_access_tokens', function (Blueprint $table) {
            $table->dropIndex('oauth_access_tokens_user_id_index');
            $table->uuid('user_id')->nullable()->change();

            // Vuelve a crear el índice o crea uno nuevo si es necesario
            // $table->index('user_id'); // Crea un nuevo índice si es necesario
        });
    }
};
