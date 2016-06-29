<?php

namespace Database\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20160629144108 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE voters (id INT AUTO_INCREMENT NOT NULL, answer_id INT DEFAULT NULL, question_id INT DEFAULT NULL, ip_address VARCHAR(255) NOT NULL, voter_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_99FAA11AA334807 (answer_id), INDEX IDX_99FAA111E27F6BF (question_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE voters ADD CONSTRAINT FK_99FAA11AA334807 FOREIGN KEY (answer_id) REFERENCES answers (id)');
        $this->addSql('ALTER TABLE voters ADD CONSTRAINT FK_99FAA111E27F6BF FOREIGN KEY (question_id) REFERENCES questions (id)');
        $this->addSql('ALTER TABLE questions CHANGE active active TINYINT(1) NOT NULL DEFAULT 1');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

            $this->addSql('DROP TABLE voters');
        $this->addSql('ALTER TABLE questions CHANGE active active TINYINT(1) DEFAULT \'1\' NOT NULL');
    }
}
