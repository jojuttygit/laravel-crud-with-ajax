<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB, Hobby;

class HobbySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hobbies = [
            'programming',
            'gamming',
            'cycling',
            'swimming'
        ];

        Hobby::truncate();
        DB::beginTransaction();

        try {
            foreach ($hobbies as $hobby) {
                $model_hobby = new Hobby;
                $model_hobby->name = $hobby;
                $model_hobby->save();
            }
            DB::commit();
            $this->command->info('Hobbies Successfully Inserted');
        } catch (Exception $e) {
            DB::rollBack();
            $this->command->info('Failed to Insert Hobbies');
        }
    }
}
