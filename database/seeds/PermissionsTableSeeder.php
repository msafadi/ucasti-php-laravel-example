<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    protected $permissions = [
        'posts.index' => 'Can list all posts',
        'posts.create' => 'Can create new post',
        'posts.edit' => 'Can edit post',
        'posts.delete' => 'Can delete post',
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        foreach ($this->permissions as $code => $name) {
            DB::table('permissions')->insert([
                'name' => $name,
                'code' => $code,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
