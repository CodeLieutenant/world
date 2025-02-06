<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Nnjeim\World\Models\Country;

class CreateCurrenciesTable extends Migration
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
        if (Schema::hasTable(config('world.migrations.currencies.table_name'))) {
            return;
        }

        Schema::create(config('world.migrations.currencies.table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->tinyInteger('precision')->default(2);
            $table->string('symbol');
            $table->string('symbol_native');
            $table->tinyInteger('symbol_first')->default(1);
            $table->string('decimal_mark', 1)->default('.');
            $table->string('thousands_separator', 1)->default(',');
            $table->foreignIdFor(Country::class)
                ->references(config('world.migrations.states.table_name'))
                ->on('id')
                ->cascadeOnDelete();

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
        Schema::dropIfExists(config('world.migrations.currencies.table_name'));
    }
}
