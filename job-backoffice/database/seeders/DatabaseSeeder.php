<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use function Illuminate\Support\now;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // seed data to test with
        $jobData = json_decode(file_get_contents(database_path('data/job-data.json')),true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job-applications.json')),true);

// create job categories

        foreach($jobData['jobCategories'] as $category){
            JobCategory::firstOrCreate(
                [
                    'name' => $category,
                ]
            );
        }
        ;

        foreach($jobData['companies'] as $company){
            //create company owner
            $companyOwner = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );
            Company::firstOrCreate(
                [
                    'name' => $company['name'],
                ],
                [
                    'address' => $company['address'],
                    'industry' => $company['industry'],
                    'website' => $company['website'],
                    'ownerId' => $companyOwner->id,
                ]
            );
        }
        ;

        //create job vacancies
        foreach($jobData['jobVacancies'] as $job){
            $company = Company::where('name',$job['company'])->firstOrFail();
            $jobCategory = JobCategory::where('name',$job['category'])->firstOrFail();
            JobVacancy::firstOrCreate(
                [
                    'title' => $job['title'],
                    'companyId' => $company->id,
                ],
                [
                    'description' => $job['description'],
                    'location' => $job['location'],
                    'salary' => $job['salary'],
                    'type' => $job['type'],
                    'jobCategoryId' => $jobCategory->id,

                ]
            );
        }
        ;

        // create job applications
        foreach($jobApplications['jobApplications'] as $application){
            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->firstOrFail();
            // create job seeker
               $jobSeeker = User::firstOrCreate(
                    [
                        'email' => fake()->unique()->safeEmail(),
                    ],
                    [
                        'name' => fake()->name(),
                        'password' => Hash::make('12345678'),
                        'role' => 'job-seeker',
                        'email_verified_at' => now(),
                    ]
                );

                // create resume
                $resume = Resume::create([
                    'userId' => $jobSeeker->id,
                    'fileName' => $application['resume']['filename'],
                    'fileUri' => $application['resume']['fileUri'],
                    'contactDetails' => $application['resume']['contactDetails'],
                    'summary' => $application['resume']['summary'],
                    'skills' => $application['resume']['skills'],
                    'experience' => $application['resume']['experience'],
                    'education' => $application['resume']['education'],
                ]);

                // create job applications
            JobApplication::create([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $jobSeeker->id,
                'resumeId' => $resume->id,

                'status' => $application['status'],

                'aiGeneratedScore' => $application['aiGeneratedScore'],
                'aiGeneratedFeedback' => $application['aiGeneratedFeedback'],
            ]);



        }


    }
}
