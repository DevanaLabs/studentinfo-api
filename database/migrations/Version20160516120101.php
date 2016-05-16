<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160516120101 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1021, \'Испит\', \'Енглески 1\', \'2016-06-16 10:00:00\', \'2016-06-16 13:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1022, \'Испит\', \'Дискретне структуре\', \'2016-06-16 10:00:00\', \'2016-06-16 13:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1023, \'Испит\', \'Увод у програмирање\', \'2016-06-18 09:00:00\', \'2016-06-18 13:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1024, \'Испит\', \'Енглески 2\', \'2016-06-18 12:00:00\', \'2016-06-18 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1025, \'Испит\', \'Пословне апликације\', \'2016-06-18 12:00:00\', \'2016-06-18 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1026, \'Испит\', \'Математичка анализа\', \'2016-06-18 15:00:00\', \'2016-06-18 18:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1027, \'Испит\', \'Објектно-оријентисано програмирање\', \'2016-06-19 12:00:00\', \'2016-06-19 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1028, \'Испит\', \'Писмено и усмено изражавање\', \'2016-06-19 09:00:00\', \'2016-06-19 12:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1029, \'Испит\', \'Алгоритми и структуре података\', \'2016-06-19 15:00:00\', \'2016-06-19 18:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1030, \'Испит\', \'Дизајн софтвера\', \'2016-06-19 15:00:00\', \'2016-06-19 18:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1031, \'Испит\', \'Интелигентни системи\', \'2016-06-20 12:00:00\', \'2016-06-20 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1032, \'Испит\', \'Алгебра\', \'2016-06-20 09:00:00\', \'2016-06-20 12:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1033, \'Испит\', \'Оперативни системи\', \'2016-06-20 09:00:00\', \'2016-06-20 12:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1034, \'Испит\', \'Рачунарске мреже\', \'2016-06-20 09:00:00\', \'2016-06-20 12:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1035, \'Испит\', \'Управљање информацијама\', \'2016-06-20 15:00:00\', \'2016-06-20 18:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1036, \'Испит\', \'Програмски преводиоци\', \'2016-06-21 12:00:00\', \'2016-06-21 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1037, \'Испит\', \'Дизајн и анализа алгоритама\', \'2016-06-21 18:00:00\', \'2016-06-21 21:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1038, \'Испит\', \'Рачунарска графика\', \'2016-06-21 15:00:00\', \'2016-06-21 18:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1039, \'Испит\', \'Симболичко рачунање\', \'2016-06-21 10:00:00\', \'2016-06-21 12:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO events (id, type, description, starts_at, ends_at, disc, organisation_id) VALUES (1040, \'Испит\', \'Софтверске компоненте\', \'2016-06-21 09:00:00\', \'2016-06-21 15:00:00\', \'course_event\', 2)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1021, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1021, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1022, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1022, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1023, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1024, 1003)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1024, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1024, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1025, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1026, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1027, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1028, 1002)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1028, 1003)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1029, 1002)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1029, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1029, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1030, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1031, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1031, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1032, 1002)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1033, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1034, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1035, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1035, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1035, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1036, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1037, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1037, 1006)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1038, 1001)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1039, 1003)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1040, 1002)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1040, 1003)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1040, 1005)');
        $this->addSql('INSERT INTO classrooms_events (event_id, classroom_id) VALUES (1040, 1006)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1022, 1002)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1023, 1003)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1021, 1004)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1025, 1005)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1026, 1006)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1027, 1007)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1024, 1009)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1028, 1010)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1029, 1011)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1030, 1012)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1031, 1013)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1032, 1014)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1033, 1015)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1034, 1016)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1035, 1017)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1037, 1018)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1036, 1019)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1038, 1020)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1039, 1022)');
        $this->addSql('INSERT INTO course_events (id, course_id) VALUES (1040, 1023)');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
