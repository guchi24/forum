<?php

use App\Channel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Channel::create([
            'name' => 'laravel',
            'slug' => Str::slug('laravel')
        ]);

        Channel::create([
            'name' => 'node.js',
            'slug' => Str::slug('node.js')
        ]);

        Channel::create([
            'name' => 'vue.js',
            'slug' => Str::slug('vue.js')
        ]);

        Channel::create([
            'name' => 'angular.js',
            'slug' => Str::slug('angular.js')
        ]);

        Channel::create([
            'name' => 'react.js',
            'slug' => Str::slug('react.js')
        ]);

    }
}
