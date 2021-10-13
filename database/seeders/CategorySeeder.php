<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB, Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'programmer',
            'designer',
            'tester'
        ];

        Category::truncate();
        DB::beginTransaction();

        try {
            foreach ($categories as $category) {
                $model_category = new Category;
                $model_category->name = $category;
                $model_category->save();
            }
            DB::commit();
            $this->command->info('Categories Successfully Inserted');
        } catch (Exception $e) {
            DB::rollBack();
            $this->command->info('Failed to Insert Categories');
        }
    }
}
