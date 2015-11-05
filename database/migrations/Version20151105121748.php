<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151105121748 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE faculties (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE students CHANGE indexNumber indexNumber VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) DEFAULT NULL, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE register_token_created_at register_token_created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD CONSTRAINT FK_1483A5E9BF396750 FOREIGN KEY (id) REFERENCES users (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE faculties');
        $this->addSql('ALTER TABLE students CHANGE indexNumber indexNumber VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE users DROP FOREIGN KEY FK_1483A5E9BF396750');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE register_token_created_at register_token_created_at VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, CHANGE password password VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
