<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160304134812 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('UPDATE courses SET semester=5 WHERE id=31');
        $this->addSql('UPDATE courses SET semester=1 WHERE id=78');
        $this->addSql('UPDATE courses SET semester=3 WHERE id=50');
        $this->addSql('UPDATE courses SET semester=7 WHERE id=104');
        $this->addSql('UPDATE courses SET semester=2 WHERE id=103');
        $this->addSql('UPDATE courses SET semester=4 WHERE id=48');
        $this->addSql('UPDATE courses SET semester=6 WHERE id=37');
        $this->addSql('UPDATE courses SET semester=8 WHERE id=25');
        $this->addSql('UPDATE classes SET name=\'Поновци\' WHERE id=28');
        $this->addSql('INSERT INTO courses (id, code, semester, espb, name, organisation_id) VALUES (\'106\', \'\' , \'2\', \'8\', \'Основи информационих система\', \'1\')');
        $this->addSql('INSERT INTO courses (id, code, semester, espb, name, organisation_id) VALUES (\'107\', \'\', \'6\', \'6\', \'Критични и безбедни системи\', \'1\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'721\', \'Радомир\', \'Јанковић\', \'faker20@fake.com\', \'$2y$10$EgyUhoZ10fN3EIgzaclTcOHgXhOBDd1Yz80oRyHde6QGijFmWeu8u\', \'professor\', \'\', \'488dac689849622d482c050e93cbf577\', \'2016-03-04 14:44:36\', \'1\')');
        $this->addSql('INSERT INTO teachers (id, title) VALUES (\'721\', \'dr\')');
        $this->addSql('INSERT INTO professors (id) VALUES (\'721\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'722\', \'Мица\', \'Милетић\', \'faker21@fake.com\', \'$2y$10$1GNsHSjG3Ws7H2xUja3rj.hTf46uebgUuwzebAJMeuVjZJUHAFSyi\', \'professor\', \'\', \'31d0500a3aca0c21bc500c906cb33acc\', \'2016-03-04 14:49:58\', \'1\')');
        $this->addSql('INSERT INTO teachers (id, title) VALUES (\'722\', \'dr\')');
        $this->addSql('INSERT INTO professors (id) VALUES (\'722\')');
        $this->addSql('INSERT INTO courses (id, code, semester, espb, name, organisation_id) VALUES (\'108\', \'\', \'0\', \'0\', \'Microsoft технологије за приступ подацима и развој web апликација\', \'1\')');
        $this->addSql('INSERT INTO courses (id, code, semester, espb, name, organisation_id) VALUES (\'109\', \'\', \'4\', \'8\', \'Лаб. Вежбе - Рачунарске мреже\', \'1\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'723\', \'Мирослав\', \'Вранеш\', \'faker22@fake.com\', \'$2y$10$FpaURJ6i9S.WMUjGDHdtGO2eW1B9QDjlonnzyul5yivtPb1yt8ihO\', \'professor\', \'\', \'6961bbeddb3d549a7255be7e2c47d037\', \'2016-03-04 14:54:11\', \'1\')');
        $this->addSql('INSERT INTO users (id, first_name, last_name, email, password, disc, remember_token, register_token, register_token_created_at, organisation_id) VALUES (\'724\', \'Microsoft\', \'предавач\', \'faker23@fake.com\', \'$2y$10$UbBXaRcf/gqGTmUwoGVikOGtUNjpdT69U8x1M/bqTUaTCuHACIMPy\', \'professor\', \'\', \'0bbddc4f4f0f51b4b4262f40eaacb668\', \'2016-03-04 14:57:37\', \'1\')');
        $this->addSql('INSERT INTO teachers (id, title) VALUES (\'723\', \'dr\')');
        $this->addSql('INSERT INTO teachers (id, title) VALUES (\'724\', \'dr\')');
        $this->addSql('INSERT INTO professors (id) VALUES (\'723\')');
        $this->addSql('INSERT INTO professors (id) VALUES (\'724\')');
        $this->addSql('INSERT INTO classes (id, name, year, organisation_id) VALUES (\'30\', \'204\', \'2\', \'1\')');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');
    }
}
