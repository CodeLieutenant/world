<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration
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
        if (Schema::hasTable(config('world.migrations.states.table_name'))) {
            return;
        }

        Schema::create(config('world.migrations.states.table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->string('name');

            foreach (config('world.migrations.states.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->string($field, $value['length'] ?? null)->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('world.migrations.states.table_name'));
    }
}
