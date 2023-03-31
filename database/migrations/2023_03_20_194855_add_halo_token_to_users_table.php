<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;

/**
 * Class AddHaloTokenToUsersTable
 *
 * Adds a column for the Halo API token to your users table.
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'users',
            fn (Blueprint $table): ColumnDefinition => $table->text('halo_token')
                ->after('password')
                ->nullable()
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(
            'users',
            fn (Blueprint $table): Fluent => $table->dropColumn('halo_token')
        );
    }
};
