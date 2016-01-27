<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160122131020 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)

    {
        $this->addSql('CREATE TABLE failed_jobs (id int(10) unsigned NOT NULL auto_increment, connection text NOT NULL, queue text NOT NULL, payload longtext NOT NULL, failed_at timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
        $this->addSql('CREATE TABLE jobs (id bigint(20) unsigned NOT NULL auto_increment, queue varchar(255) NOT NULL, payload longtext NOT NULL,  attempts tinyint(3) unsigned NOT NULL, reserved tinyint(3) unsigned NOT NULL, reserved_at int(10) unsigned, available_at int(10) unsigned NOT NULL, created_at int(10) unsigned NOT NULL, PRIMARY KEY (id), KEY jobs_queue_reserved_reserved_at_index (queue,reserved,reserved_at)) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'718\', \'Raf\', \'Raf\', \'table@raf.edu.rs\', \'$2y$10$.Me8tPYwiBJp.Emn8k//8.9Zm71zGIqyFS.Mp9FscvONIaXfKsgLG\', \'student\', \'eMg28rfbEjvPSfPbcLBCFtjoTYssDrZrLYLy70yx8ziAu8fHBnPPy0QHfyzs\', \'\', \'2016-01-27 12:08:50\', \'1\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'719\', \'Raf\', \'Raf\', \'raf@raf.edu.rs\', \'$2y$10$R6Kzgzpnm9z8oB15NdNPz.wHVVA1Z19kWwjntJxS3lO.fQAWCiUhW\', \'admin\', \'\', \'\', \'2016-01-27 12:29:03\', \'1\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'720\', \'Super\', \'User\', \'super@labs.devana.rs\', \'$2y$10$wLZo5znoeP148TY0sjuau.dXxRnUWoijyvurR3xoxEz2NaP4H3NH.\', \'superUser\', \'\', \'\', \'2016-01-27 14:05:39\', \'1\')');
        $this->addSql('INSERT INTO students (id, index_number, year) VALUES (\'718\', \'\', \'0\')');
        $this->addSql('INSERT INTO admins (id) VALUES (\'719\')');
        $this->addSql('INSERT INTO superUsers (id) VALUES (\'720\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE jobs');
        $this->addSql('DROP TABLE failed_jobs');
    }
}
