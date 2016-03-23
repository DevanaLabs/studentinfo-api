<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160323145635 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculties ADD semester INT NOT NULL, ADD year INT NOT NULL');
        $this->addSql('ALTER TABLE lectures CHANGE year year INT NOT NULL');
        $this->addSql('UPDATE faculties SET year=2016, semester=2 WHERE id=1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE faculties DROP semester, DROP year');
        $this->addSql('ALTER TABLE lectures CHANGE year year SMALLINT NOT NULL');
    }
}
