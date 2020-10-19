<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * The tables that are not truncated
     *
     * @var array
     */
    protected $guardedTables = [];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateDatabase();

        $this->call([
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
        ProductsTableSeeder::class,
        CustomersSeeder::class,
        // PostsTableSeeder::class,
        GallerySeeder::class,
        ]);
    }

    /**
     * Gets the database tables name.
     *
     * @return Illuminate\Support\Collection
     */
    protected function getDatabaseTables()
    {
        $tablesNames = array_map('current', DB::select('SHOW TABLES'));

        return collect($tablesNames)->diff($this->guardedTables)->values();
    }

    /**
     * Truncate all the database tables except the guarde tables.
     *
     * @return void
     */
    protected function truncateDatabase()
    {
        Schema::disableForeignKeyConstraints();

        $this->getDatabaseTables()->each(function ($table) {
            DB::table($table)->truncate();
        });

        Schema::enableForeignKeyConstraints();
    }
}
