<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210141437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workers ALTER start_time TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER start_time DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER end_time TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER end_time DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER start_break TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER start_break DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER end_break TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER end_break DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN workers.start_time IS \'(DC2Type:time_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.end_time IS \'(DC2Type:time_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.start_break IS \'(DC2Type:time_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.end_break IS \'(DC2Type:time_immutable)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE workers ALTER start_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER start_time DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER end_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER end_time DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER start_break TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER start_break DROP DEFAULT');
        $this->addSql('ALTER TABLE workers ALTER end_break TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE workers ALTER end_break DROP DEFAULT');
        $this->addSql('COMMENT ON COLUMN workers.start_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.end_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.start_break IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN workers.end_break IS \'(DC2Type:datetime_immutable)\'');
    }
}
