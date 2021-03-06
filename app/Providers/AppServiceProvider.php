<?php

namespace StudentInfo\Providers;

use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Queue;
use StudentInfo\Models\ActivityLog;
use StudentInfo\Models\Admin;
use StudentInfo\Models\Assistant;
use StudentInfo\Models\Classroom;
use StudentInfo\Models\Course;
use StudentInfo\Models\CourseEvent;
use StudentInfo\Models\DeviceToken;
use StudentInfo\Models\Event;
use StudentInfo\Models\Faculty;
use StudentInfo\Models\Feedback;
use StudentInfo\Models\GlobalEvent;
use StudentInfo\Models\Group;
use StudentInfo\Models\GroupEvent;
use StudentInfo\Models\Lecture;
use StudentInfo\Models\Notification;
use StudentInfo\Models\Panel;
use StudentInfo\Models\PollAnswer;
use StudentInfo\Models\PollQuestion;
use StudentInfo\Models\Professor;
use StudentInfo\Models\Student;
use StudentInfo\Models\SuperUser;
use StudentInfo\Models\Teacher;
use StudentInfo\Models\User;
use StudentInfo\Models\Voter;
use StudentInfo\Repositories\DoctrineActivityLogRepository;
use StudentInfo\Repositories\DoctrineAdminRepository;
use StudentInfo\Repositories\DoctrineAssistantRepository;
use StudentInfo\Repositories\DoctrineClassroomRepository;
use StudentInfo\Repositories\DoctrineCourseEventRepository;
use StudentInfo\Repositories\DoctrineCourseRepository;
use StudentInfo\Repositories\DoctrineDeviceTokenRepository;
use StudentInfo\Repositories\DoctrineEventNotificationRepository;
use StudentInfo\Repositories\DoctrineEventRepository;
use StudentInfo\Repositories\DoctrineFacultyRepository;
use StudentInfo\Repositories\DoctrineFeedbackRepository;
use StudentInfo\Repositories\DoctrineGlobalEventRepository;
use StudentInfo\Repositories\DoctrineGroupEventRepository;
use StudentInfo\Repositories\DoctrineGroupRepository;
use StudentInfo\Repositories\DoctrineLectureNotificationRepository;
use StudentInfo\Repositories\DoctrineLectureRepository;
use StudentInfo\Repositories\DoctrineNotificationRepository;
use StudentInfo\Repositories\DoctrinePanelRepository;
use StudentInfo\Repositories\DoctrinePollAnswerRepository;
use StudentInfo\Repositories\DoctrinePollQuestionRepository;
use StudentInfo\Repositories\DoctrineProfessorRepository;
use StudentInfo\Repositories\DoctrineStudentRepository;
use StudentInfo\Repositories\DoctrineSuperUserRepository;
use StudentInfo\Repositories\DoctrineTeacherRepository;
use StudentInfo\Repositories\DoctrineUserRepository;
use StudentInfo\Repositories\DoctrineVoterRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function ($connection, $job, $data) {
            Log::info("Email was sent successfully at: ".time());
        });
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
        $this->app->bind('StudentInfo\Repositories\EventNotificationRepositoryInterface', function ($app) {
            return new DoctrineEventNotificationRepository(
                $app['em'],
                new ClassMetaData(Notification::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\LectureNotificationRepositoryInterface', function ($app) {
            return new DoctrineLectureNotificationRepository(
                $app['em'],
                new ClassMetaData(Notification::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\DeviceTokenRepositoryInterface', function ($app) {
            return new DoctrineDeviceTokenRepository(
                $app['em'],
                new ClassMetaData(DeviceToken::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\PanelRepositoryInterface', function ($app) {
            return new DoctrinePanelRepository(
                $app['em'],
                new ClassMetaData(Panel::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\ActivityLogRepositoryInterface', function ($app) {
            return new DoctrineActivityLogRepository(
                $app['em'],
                new ClassMetaData(ActivityLog::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\PollQuestionRepositoryInterface', function ($app) {
            return new DoctrinePollQuestionRepository(
                $app['em'],
                new ClassMetaData(PollQuestion::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\PollAnswerRepositoryInterface', function ($app) {
            return new DoctrinePollAnswerRepository(
                $app['em'],
                new ClassMetaData(PollAnswer::class)
            );
        });
        $this->app->bind('StudentInfo\Repositories\VoterRepositoryInterface', function ($app) {
            return new DoctrineVoterRepository(
                $app['em'],
                new ClassMetaData(Voter::class)
            );
        });
    }
}
