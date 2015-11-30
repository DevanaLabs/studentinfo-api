<?php

namespace StudentInfo\Providers;

use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;
use StudentInfo\Models\Admin;
use StudentInfo\Models\Student;
use StudentInfo\Models\SuperUser;
use StudentInfo\Models\User;
use StudentInfo\Repositories\DoctrineAdminRepository;
use StudentInfo\Repositories\DoctrineClassroomRepository;
use StudentInfo\Repositories\DoctrineCourseRepository;
use StudentInfo\Repositories\DoctrineEventRepository;
use StudentInfo\Repositories\DoctrineFacultyRepository;
use StudentInfo\Repositories\DoctrineGroupRepository;
use StudentInfo\Repositories\DoctrineLectureRepository;
use StudentInfo\Repositories\DoctrineProfessorRepository;
use StudentInfo\Repositories\DoctrineStudentRepository;
use StudentInfo\Repositories\DoctrineSuperUserRepository;
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

        $this->app->bind('StudentInfo\Repositories\AdminRepositoryInterface', function ($app) {
            return new DoctrineAdminRepository(
                $app['em'],
                new ClassMetaData(User::class)
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
        $this->app->bind('StudentInfo\Repositories\CourseRepositoryInterface', function ($app) {
            return new DoctrineCourseRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\LectureRepositoryInterface', function ($app) {
            return new DoctrineLectureRepository(
                $app['em'],
                new ClassMetaData(Student::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\GroupRepositoryInterface', function ($app) {
            return new DoctrineGroupRepository(
                $app['em'],
                new ClassMetaData(User::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\EventRepositoryInterface', function ($app) {
            return new DoctrineEventRepository(
                $app['em'],
                new ClassMetaData(User::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\SuperUserRepositoryInterface', function ($app) {
            return new DoctrineSuperUserRepository(
                $app['em'],
                new ClassMetaData(User::class)
            );
        });
    }
}
