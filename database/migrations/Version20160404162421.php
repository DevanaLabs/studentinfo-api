<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160404162421 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('UPDATE faculties SET name=\'Рачунарски факултет\', university=\'Унион\' WHERE id=1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
