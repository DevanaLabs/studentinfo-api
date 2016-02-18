<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160216104757 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE oauth_sessions CHANGE owner_type owner_type VARCHAR(40) not null default \'user\'');
        $this->addSql('INSERT INTO oauth_clients (id, secret, name, created_at, updated_at) VALUES (\'2\', \'secret\', \'android\', \'2016-02-16 11:02:57\', \'0000-00-00 00:00:00\')');
        $this->addSql('INSERT INTO oauth_clients (id, secret, name, created_at, updated_at) VALUES (\'3\', \'secret\', \'ios\', \'2016-02-16 11:03:05\', \'0000-00-00 00:00:00\')');
        $this->addSql('ALTER TABLE deviceTokens ADD active SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE students CHANGE index_number index_number VARCHAR(255) NOT NULL, CHANGE year year INT NOT NULL');
        $this->addSql('ALTER TABLE teachers CHANGE title title VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) NOT NULL, CHANGE last_name last_name VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE oauth_sessions CHANGE owner_type owner_type enum(\'client\',\'user\') not null default \'user\'');
        $this->addSql('ALTER TABLE deviceTokens DROP active');
        $this->addSql('ALTER TABLE students CHANGE index_number index_number VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE year year INT DEFAULT NULL');
        $this->addSql('ALTER TABLE teachers CHANGE title title VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE users CHANGE first_name first_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE last_name last_name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci');
    }
}