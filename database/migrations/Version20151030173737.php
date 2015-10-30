<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20151030173737 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admins (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE students (id INT NOT NULL, indexNumber VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A4698DB2E9CD7668 (indexNumber), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hashed_password VARCHAR(255) NOT NULL, disc VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admins ADD CONSTRAINT FK_A2E0150FBF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE students ADD CONSTRAINT FK_A4698DB2BF396750 FOREIGN KEY (id) REFERENCES users (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE admins DROP FOREIGN KEY FK_A2E0150FBF396750');
        $this->addSql('ALTER TABLE students DROP FOREIGN KEY FK_A4698DB2BF396750');
        $this->addSql('DROP TABLE admins');
        $this->addSql('DROP TABLE students');
        $this->addSql('DROP TABLE users');
    }
}
