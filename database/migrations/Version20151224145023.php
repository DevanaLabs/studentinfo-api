<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151224145023 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE assistants (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE course_events (id INT NOT NULL, course_id INT DEFAULT NULL, INDEX IDX_FDBF9607591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE events (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, disc VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classrooms_events (event_id INT NOT NULL, classroom_id INT NOT NULL, INDEX IDX_8E9C06F871F7E88B (event_id), INDEX IDX_8E9C06F86278D5A8 (classroom_id), PRIMARY KEY(event_id, classroom_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_notifications (id INT NOT NULL, event_id INT DEFAULT NULL, INDEX IDX_4459007F71F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE faculties (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, university VARCHAR(255) NOT NULL, wallpaper_path VARCHAR(255) NOT NULL, language VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE global_events (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, year INT NOT NULL, UNIQUE INDEX UNIQ_2ED7EC55E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE class_events (id INT NOT NULL, class_id INT DEFAULT NULL, INDEX IDX_9CDB15F2EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes_lectures (lecture_id INT NOT NULL, class_id INT NOT NULL, INDEX IDX_293D87C935E32FCD (lecture_id), INDEX IDX_293D87C9EA000B10 (class_id), PRIMARY KEY(lecture_id, class_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lecture_notifications (id INT NOT NULL, lecture_id INT DEFAULT NULL, INDEX IDX_BC3C196135E32FCD (lecture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notifications (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, disc VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE superUsers (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE teachers (id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assistants ADD CONSTRAINT FK_EA18B435BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE course_events ADD CONSTRAINT FK_FDBF9607591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE course_events ADD CONSTRAINT FK_FDBF9607BF396750 FOREIGN KEY (id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classrooms_events ADD CONSTRAINT FK_8E9C06F871F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE classrooms_events ADD CONSTRAINT FK_8E9C06F86278D5A8 FOREIGN KEY (classroom_id) REFERENCES classrooms (id)');
        $this->addSql('ALTER TABLE event_notifications ADD CONSTRAINT FK_4459007F71F7E88B FOREIGN KEY (event_id) REFERENCES events (id)');
        $this->addSql('ALTER TABLE event_notifications ADD CONSTRAINT FK_4459007FBF396750 FOREIGN KEY (id) REFERENCES notifications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE global_events ADD CONSTRAINT FK_BC16421ABF396750 FOREIGN KEY (id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE class_events ADD CONSTRAINT FK_9CDB15F2EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE class_events ADD CONSTRAINT FK_9CDB15F2BF396750 FOREIGN KEY (id) REFERENCES events (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes_lectures ADD CONSTRAINT FK_293D87C935E32FCD FOREIGN KEY (lecture_id) REFERENCES lectures (id)');
        $this->addSql('ALTER TABLE classes_lectures ADD CONSTRAINT FK_293D87C9EA000B10 FOREIGN KEY (class_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE lecture_notifications ADD CONSTRAINT FK_BC3C196135E32FCD FOREIGN KEY (lecture_id) REFERENCES lectures (id)');
        $this->addSql('ALTER TABLE lecture_notifications ADD CONSTRAINT FK_BC3C1961BF396750 FOREIGN KEY (id) REFERENCES notifications (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE superUsers ADD CONSTRAINT FK_6494F39FBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE teachers ADD CONSTRAINT FK_ED071FF6BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classrooms ADD floor INT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_A9A55A4C77153098 ON courses');
        $this->addSql('ALTER TABLE courses ADD name VARCHAR(255) NOT NULL, CHANGE esp espb INT NOT NULL');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D07D2D84D5');
        $this->addSql('DROP INDEX IDX_63C861D07D2D84D5 ON lectures');
        $this->addSql('ALTER TABLE lectures ADD type VARCHAR(255) NOT NULL, ADD starts_at DATETIME NOT NULL, ADD ends_at DATETIME NOT NULL, CHANGE professor_id teacher_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D041807E1D FOREIGN KEY (teacher_id) REFERENCES teachers (id)');
        $this->addSql('CREATE INDEX IDX_63C861D041807E1D ON lectures (teacher_id)');
        $this->addSql('ALTER TABLE professors DROP first_name, DROP last_name, CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE professors ADD CONSTRAINT FK_2274711EBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQ_A4698DB2E9CD7668 ON students');
        $this->addSql('ALTER TABLE students CHANGE indexnumber index_number VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB28F0EE0A5 ON students (index_number)');
        $this->addSql('ALTER TABLE users ADD organisation_id INT DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE register_token register_token VARCHAR(32) DEFAULT NULL, CHANGE register_token_created_at register_token_created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E99E6B1585 FOREIGN KEY (organisation_id) REFERENCES faculties (id)');
        $this->addSql('CREATE INDEX IDX_1483A5E99E6B1585 ON users (organisation_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE course_events DROP FOREIGN KEY FK_FDBF9607BF396750');
        $this->addSql('ALTER TABLE classrooms_events DROP FOREIGN KEY FK_8E9C06F871F7E88B');
        $this->addSql('ALTER TABLE event_notifications DROP FOREIGN KEY FK_4459007F71F7E88B');
        $this->addSql('ALTER TABLE global_events DROP FOREIGN KEY FK_BC16421ABF396750');
        $this->addSql('ALTER TABLE class_events DROP FOREIGN KEY FK_9CDB15F2BF396750');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E99E6B1585');
        $this->addSql('ALTER TABLE class_events DROP FOREIGN KEY FK_9CDB15F2EA000B10');
        $this->addSql('ALTER TABLE classes_lectures DROP FOREIGN KEY FK_293D87C9EA000B10');
        $this->addSql('ALTER TABLE event_notifications DROP FOREIGN KEY FK_4459007FBF396750');
        $this->addSql('ALTER TABLE lecture_notifications DROP FOREIGN KEY FK_BC3C1961BF396750');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D041807E1D');
        $this->addSql('DROP TABLE assistants');
        $this->addSql('DROP TABLE course_events');
        $this->addSql('DROP TABLE events');
        $this->addSql('DROP TABLE classrooms_events');
        $this->addSql('DROP TABLE event_notifications');
        $this->addSql('DROP TABLE faculties');
        $this->addSql('DROP TABLE feedback');
        $this->addSql('DROP TABLE global_events');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE class_events');
        $this->addSql('DROP TABLE classes_lectures');
        $this->addSql('DROP TABLE lecture_notifications');
        $this->addSql('DROP TABLE notifications');
        $this->addSql('DROP TABLE superUsers');
        $this->addSql('DROP TABLE teachers');
        $this->addSql('ALTER TABLE classrooms DROP floor');
        $this->addSql('ALTER TABLE courses DROP name, CHANGE espb esp INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A9A55A4C77153098 ON courses (code)');
        $this->addSql('DROP INDEX IDX_63C861D041807E1D ON lectures');
        $this->addSql('ALTER TABLE lectures DROP type, DROP starts_at, DROP ends_at, CHANGE teacher_id professor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D07D2D84D5 FOREIGN KEY (professor_id) REFERENCES professors (id)');
        $this->addSql('CREATE INDEX IDX_63C861D07D2D84D5 ON lectures (professor_id)');
        $this->addSql('ALTER TABLE professors DROP FOREIGN KEY FK_2274711EBF396750');
        $this->addSql('ALTER TABLE professors ADD first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, ADD last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('DROP INDEX UNIQ_A4698DB28F0EE0A5 ON students');
        $this->addSql('ALTER TABLE students CHANGE index_number indexNumber VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A4698DB2E9CD7668 ON students (indexNumber)');
        $this->addSql('DROP INDEX IDX_1483A5E99E6B1585 ON users');
        $this->addSql('ALTER TABLE users DROP organisation_id, CHANGE register_token register_token VARCHAR(32) NOT NULL COLLATE utf8_unicode_ci, CHANGE register_token_created_at register_token_created_at VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
