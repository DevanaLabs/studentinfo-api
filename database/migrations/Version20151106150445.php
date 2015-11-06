<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151106150445 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE professors (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classrooms (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, directions VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lectures_students (student_id INT NOT NULL, lecture_id INT NOT NULL, INDEX IDX_F37D85D6CB944F1A (student_id), INDEX IDX_F37D85D635E32FCD (lecture_id), PRIMARY KEY(student_id, lecture_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses_students (student_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_5D696B20CB944F1A (student_id), INDEX IDX_5D696B20591CC992 (course_id), PRIMARY KEY(student_id, course_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courses (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, semester INT NOT NULL, esp INT NOT NULL, UNIQUE INDEX UNIQ_A9A55A4C77153098 (code), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lectures (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, professor_id INT DEFAULT NULL, classroom_id INT DEFAULT NULL, INDEX IDX_63C861D0591CC992 (course_id), INDEX IDX_63C861D07D2D84D5 (professor_id), INDEX IDX_63C861D06278D5A8 (classroom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lectures_students ADD CONSTRAINT FK_F37D85D6CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE lectures_students ADD CONSTRAINT FK_F37D85D635E32FCD FOREIGN KEY (lecture_id) REFERENCES lectures (id)');
        $this->addSql('ALTER TABLE courses_students ADD CONSTRAINT FK_5D696B20CB944F1A FOREIGN KEY (student_id) REFERENCES students (id)');
        $this->addSql('ALTER TABLE courses_students ADD CONSTRAINT FK_5D696B20591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D0591CC992 FOREIGN KEY (course_id) REFERENCES courses (id)');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D07D2D84D5 FOREIGN KEY (professor_id) REFERENCES professors (id)');
        $this->addSql('ALTER TABLE lectures ADD CONSTRAINT FK_63C861D06278D5A8 FOREIGN KEY (classroom_id) REFERENCES classrooms (id)');
        $this->addSql('DROP TABLE faculties');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE register_token_created_at register_token_created_at VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE students ADD year INT NOT NULL, CHANGE indexNumber indexNumber VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D07D2D84D5');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D06278D5A8');
        $this->addSql('ALTER TABLE courses_students DROP FOREIGN KEY FK_5D696B20591CC992');
        $this->addSql('ALTER TABLE lectures DROP FOREIGN KEY FK_63C861D0591CC992');
        $this->addSql('ALTER TABLE lectures_students DROP FOREIGN KEY FK_F37D85D635E32FCD');
        $this->addSql('CREATE TABLE faculties (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE professors');
        $this->addSql('DROP TABLE classrooms');
        $this->addSql('DROP TABLE lectures_students');
        $this->addSql('DROP TABLE courses_students');
        $this->addSql('DROP TABLE courses');
        $this->addSql('DROP TABLE lectures');
        $this->addSql('ALTER TABLE students DROP year, CHANGE indexNumber indexNumber VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE register_token_created_at register_token_created_at DATETIME NOT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}
