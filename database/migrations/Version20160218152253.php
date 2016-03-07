<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160218152253 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lectures CHANGE type type INT NOT NULL');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=1');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=2');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=3');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=4');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=5');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=6');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=7');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=8');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=9');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=10');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=11');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=12');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=13');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=14');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=15');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=16');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=17');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=18');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=19');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=20');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=21');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=22');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=23');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=24');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=25');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=26');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=27');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=28');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=29');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=30');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=31');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=32');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=33');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=34');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=35');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=36');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=37');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=38');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=39');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=40');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=41');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=42');
        $this->addSql('UPDATE lectures SET type=2 WHERE id=43');
        $this->addSql('UPDATE lectures SET type=2 WHERE id=44');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=45');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=46');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=47');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=48');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=49');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=50');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=51');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=52');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=53');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=54');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=55');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=56');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=57');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=58');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=59');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=60');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=61');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=62');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=63');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=64');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=65');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=66');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=67');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=68');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=69');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=70');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=71');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=72');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=73');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=74');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=75');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=76');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=77');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=78');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=79');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=80');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=81');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=82');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=83');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=84');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=85');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=86');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=87');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=88');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=89');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=90');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=91');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=92');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=93');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=94');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=95');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=96');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=97');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=98');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=99');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=100');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=101');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=102');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=103');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=104');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=105');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=106');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=107');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=108');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=109');
        $this->addSql('UPDATE lectures SET type=2 WHERE id=110');
        $this->addSql('UPDATE lectures SET type=2 WHERE id=111');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=112');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=113');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=114');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=115');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=116');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=117');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=118');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=119');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=120');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=121');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=122');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=123');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=124');
        $this->addSql('UPDATE lectures SET type=3 WHERE id=125');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=126');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=127');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=128');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=129');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=130');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=131');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=132');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=133');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=134');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=135');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=136');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=137');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=138');
        $this->addSql('UPDATE lectures SET type=0 WHERE id=139');
        $this->addSql('UPDATE lectures SET type=1 WHERE id=140');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lectures CHANGE type type VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
