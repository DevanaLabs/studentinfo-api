<?php

namespace StudentInfo\Providers;

use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;
use StudentInfo\Models\Admin;
use StudentInfo\Models\Assistant;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Course;
use StudentInfo\Models\CourseEvent;
use StudentInfo\Models\Event;
use StudentInfo\Models\Faculty;
use StudentInfo\Models\Feedback;
use StudentInfo\Models\GlobalEvent;
use StudentInfo\Models\Group;
use StudentInfo\Models\GroupEvent;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Notification;
use StudentInfo\Models\Professor;
use StudentInfo\Models\Student;
use StudentInfo\Models\SuperUser;
use StudentInfo\Models\Teacher;
use StudentInfo\Models\User;
use StudentInfo\Repositories\DoctrineAdminRepository;
use StudentInfo\Repositories\DoctrineAssistantRepository;
use StudentInfo\Repositories\DoctrineClassroomRepository;
use StudentInfo\Repositories\DoctrineCourseEventRepository;
use StudentInfo\Repositories\DoctrineCourseRepository;
use StudentInfo\Repositories\DoctrineEventRepository;
use StudentInfo\Repositories\DoctrineFacultyRepository;
use StudentInfo\Repositories\DoctrineFeedbackRepository;
use StudentInfo\Repositories\DoctrineGlobalEventRepository;
use StudentInfo\Repositories\DoctrineGroupEventRepository;
use StudentInfo\Repositories\DoctrineGroupRepository;
use StudentInfo\Repositories\DoctrineLectureRepository;
use StudentInfo\Repositories\DoctrineNotificationRepository;
use StudentInfo\Repositories\DoctrineProfessorRepository;
use StudentInfo\Repositories\DoctrineStudentRepository;
use StudentInfo\Repositories\DoctrineSuperUserRepository;
use StudentInfo\Repositories\DoctrineTeacherRepository;
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
                new ClassMetaData(Admin::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\ClassroomRepositoryInterface', function ($app) {
            return new DoctrineClassroomRepository(
                $app['em'],
                new ClassMetaData(Classroom::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\ProfessorRepositoryInterface', function ($app) {
            return new DoctrineProfessorRepository(
                $app['em'],
                new ClassMetaData(Professor::class)
            );
        });

        $this->app->bind('StudentInfo\Repositories\FacultyRepositoryInterface', function ($app) {
            return new DoctrineFacultyRepository(
                $app['em'],
                new ClassMetaData(Faculty::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\CourseRepositoryInterface', function ($app) {
            return new DoctrineCourseRepository(
                $app['em'],
                new ClassMetaData(Course::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\LectureRepositoryInterface', function ($app) {
            return new DoctrineLectureRepository(
                $app['em'],
                new ClassMetaData(Lecture::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\GroupRepositoryInterface', function ($app) {
            return new DoctrineGroupRepository(
                $app['em'],
                new ClassMetaData(Group::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\EventRepositoryInterface', function ($app) {
            return new DoctrineEventRepository(
                $app['em'],
                new ClassMetaData(Event::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\GlobalEventRepositoryInterface', function ($app) {
            return new DoctrineGlobalEventRepository(
                $app['em'],
                new ClassMetaData(GlobalEvent::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\GroupEventRepositoryInterface', function ($app) {
            return new DoctrineGroupEventRepository(
                $app['em'],
                new ClassMetaData(GroupEvent::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\CourseEventRepositoryInterface', function ($app) {
            return new DoctrineCourseEventRepository(
                $app['em'],
                new ClassMetaData(CourseEvent::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\SuperUserRepositoryInterface', function ($app) {
            return new DoctrineSuperUserRepository(
                $app['em'],
                new ClassMetaData(SuperUser::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\NotificationRepositoryInterface', function ($app) {
            return new DoctrineNotificationRepository(
                $app['em'],
                new ClassMetaData(Notification::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\TeacherRepositoryInterface', function ($app) {
            return new DoctrineTeacherRepository(
                $app['em'],
                new ClassMetaData(Teacher::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\AssistantRepositoryInterface', function ($app) {
            return new DoctrineAssistantRepository(
                $app['em'],
                new ClassMetaData(Assistant::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\FeedbackRepositoryInterface', function ($app) {
            return new DoctrineFeedbackRepository(
                $app['em'],
                new ClassMetaData(Feedback::class)
            );
        });
    }
}
