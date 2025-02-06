<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    public function __construct()
    {
        $this->connection ??= config('world.connection');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        if (Schema::hasTable(config('world.migrations.languages.table_name'))) {
            return;
        }

        Schema::create(config('world.migrations.languages.table_name'), function (Blueprint $table) {
            $table->id();
            $table->char('code', 2)->unique();
            $table->string('name')->unique();
            $table->string('name_native');
            $table->char('dir', 3);

            $table->unique(['name', 'code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('world.migrations.languages.table_name'));
    }
}
