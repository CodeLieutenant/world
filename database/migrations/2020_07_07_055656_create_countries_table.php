<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
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
        if (Schema::hasTable(config('world.migrations.countries.table_name'))) {
            return;
        }

        Schema::create(config('world.migrations.countries.table_name'), function (Blueprint $table) {
            $table->id();
            $table->char('iso2', 2)->unique();
            $table->string('name')->unique();
            $table->tinyInteger('status')->default(1);

            foreach (config('world.migrations.countries.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->{$value['type']}($field, $value['length'] ?? null);
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
        Schema::dropIfExists(config('world.migrations.countries.table_name'));
    }
}
