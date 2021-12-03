<?php

namespace Database\Seeders;

use App\Models\PostLike;
use Illuminate\Database\Seeder;

class PostLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PostLike::factory(20)->create();
    }
}
