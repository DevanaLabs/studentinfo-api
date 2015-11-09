<?php

namespace StudentInfo\Providers;

use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;
use StudentInfo\Models\Student;
use StudentInfo\Models\User;
use StudentInfo\Repositories\DoctrineClassroomRepository;
use StudentInfo\Repositories\DoctrineFacultyRepository;
use StudentInfo\Repositories\DoctrineProfessorRepository;
use StudentInfo\Repositories\DoctrineStudentRepository;
use StudentInfo\Repositories\DoctrineUserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('StudentInfo\Repositories\UserRepositoryInterface', function ($app) {
            return new DoctrineUserRepository(
                $app['em'],
                new ClassMetaData(User::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\StudentRepositoryInterface', function ($app) {
            return new DoctrineStudentRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\ClassroomRepositoryInterface', function ($app) {
            return new DoctrineClassroomRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\ProfessorRepositoryInterface', function ($app) {
            return new DoctrineProfessorRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\FacultyRepositoryInterface', function ($app) {
            return new DoctrineFacultyRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });
    }
}
