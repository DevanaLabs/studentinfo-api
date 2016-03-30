<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160327171414 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql('UPDATE events SET ends_at=\'2016-02-10 23:59:00\' WHERE id=1');
        $this->addSql('UPDATE events SET ends_at=\'2016-02-28 23:59:00\' WHERE id=2');
        $this->addSql('UPDATE events SET ends_at=\'2016-06-30 23:59:00\' WHERE id=3');
        $this->addSql('UPDATE events SET ends_at=\'2016-07-14 23:59:00\' WHERE id=4');
        $this->addSql('UPDATE events SET ends_at=\'2016-09-04 23:59:00\' WHERE id=5');
        $this->addSql('UPDATE events SET ends_at=\'2016-09-15 23:59:00\' WHERE id=6');
        $this->addSql('UPDATE events SET ends_at=\'2016-09-26 23:59:00\' WHERE id=7');
        $this->addSql('UPDATE events SET ends_at=\'2015-11-29 23:59:00\' WHERE id=8');
        $this->addSql('UPDATE events SET ends_at=\'2016-01-20 23:59:00\' WHERE id=9');
        $this->addSql('UPDATE events SET ends_at=\'2016-04-24 23:59:00\' WHERE id=10');
        $this->addSql('UPDATE events SET ends_at=\'2016-06-09 23:59:00\' WHERE id=11');
        $this->addSql('UPDATE events SET ends_at=\'2015-10-01 23:59:00\' WHERE id=12');
        $this->addSql('UPDATE events SET ends_at=\'2015-12-31 23:59:00\' WHERE id=13');
        $this->addSql('UPDATE events SET ends_at=\'2016-04-01 23:59:00\' WHERE id=14');
        $this->addSql('UPDATE events SET ends_at=\'2015-11-11 23:59:00\' WHERE id=15');
        $this->addSql('UPDATE events SET ends_at=\'2016-01-02 23:59:00\' WHERE id=16');
        $this->addSql('UPDATE events SET ends_at=\'2016-01-07 23:59:00\' WHERE id=17');
        $this->addSql('UPDATE events SET ends_at=\'2016-02-16 23:59:00\' WHERE id=18');
        $this->addSql('UPDATE events SET ends_at=\'2016-05-03 23:59:00\' WHERE id=19');
        $this->addSql('UPDATE events SET ends_at=\'2016-08-21 23:59:00\' WHERE id=20');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

    }
}
