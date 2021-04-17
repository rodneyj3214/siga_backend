<?php

namespace Database\Seeders;

use App\Models\App\Authority;
use App\Models\App\AuthorityType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AuthenticationSeeder::class,
            JobBoardSeeder::class,
        ]);
    }
}
/*
                drop schema if exists public cascade;
                drop schema if exists authentication cascade;
                drop schema if exists attendance cascade;
                drop schema if exists app cascade;
                drop schema if exists job_board cascade;
                drop schema if exists web cascade;
                drop schema if exists teacher_eval cascade;
                drop schema if exists community cascade;
                    drop schema if exists cecy cascade;

            create schema authentication;
            create schema attendance;
            create schema app;
            create schema job_board;
            create schema web;
            create schema teacher_eval;
            create schema community;
            create schema cecy;
 */
