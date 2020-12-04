<?php

use App\Job;
use App\JobApplication;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        User::truncate();
        Job::truncate();
        JobApplication::truncate();

        User::flushEventListeners();
        Job::flushEventListeners();
        JobApplication::flushEventListeners();

        $usersQuantity = 10;
        $jobsQuantity = 10;
        $jobApplicationsQuantity = 5;

        factory(User::class, $usersQuantity)->create();
        factory(Job::class, $jobsQuantity)->create();
        factory(JobApplication::class, $jobApplicationsQuantity)->create();
    }
}
