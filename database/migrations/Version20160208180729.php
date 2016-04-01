<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160208180729 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('INSERT INTO oauth_clients (id, secret, name, created_at, updated_at) VALUES (\'1\', \'secret\', \'homestead\', \'2016-02-03 11:15:25\', \'2016-01-18 17:22:29\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
