<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nnjeim\World\Models\Country;
use Nnjeim\World\Models\State;

class CreateCitiesTable extends Migration
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
        if (Schema::hasTable(config('world.migrations.cities.table_name'))) {
            return;
        }

        Schema::create(config('world.migrations.cities.table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();

            foreach (config('world.migrations.cities.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->{$value['type']}($field, $value['length'] ?? null);
                }
            }

            $table->foreignIdFor(Country::class)
                ->references(config('world.migrations.countries.table_name'))
                ->on('id')
                ->cascadeOnDelete();
            $table->foreignIdFor(State::class)
                ->references(config('world.migrations.states.table_name'))
                ->on('id')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(config('world.migrations.cities.table_name'));
    }
}
