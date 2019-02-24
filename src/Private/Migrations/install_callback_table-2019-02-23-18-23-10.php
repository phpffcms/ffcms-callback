<?php

use Ffcms\Core\Migrations\MigrationInterface;
use Ffcms\Core\Migrations\Migration;

/**
 * Class install_callback_table.
 */
class install_callback_table extends Migration implements MigrationInterface
{
    /**
     * Execute actions when migration is up
     * @return void
     */
    public function up()
    {
        $this->getSchema()->create('callback', function ($table) {
            /** @var \Illuminate\Database\Schema\Blueprint $table */
            $table->increments('id');
            $table->string('name', 1024);
            $table->string('phone', 32);
            $table->text('more')->nullable();
            $table->timestamps();
        });
        parent::up();
    }

    /**
     * Seed created table via up() method with some data
     * @return void
     */
    public function seed() {}

    /**
     * Execute actions when migration is down
     * @return void
     */
    public function down()
    {
        $this->getSchema()->dropIfExists('callback');
        parent::down();
    }
}