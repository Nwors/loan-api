<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241012165840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE app_user_product (id UUID NOT NULL, user_id UUID NOT NULL, product_id UUID NOT NULL, interest_rate DOUBLE PRECISION NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_49C90026A76ED395 ON app_user_product (user_id)');
        $this->addSql('CREATE INDEX IDX_49C900264584665A ON app_user_product (product_id)');
        $this->addSql('COMMENT ON COLUMN app_user_product.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN app_user_product.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN app_user_product.product_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN app_user_product.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN app_user_product.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE app_user_product ADD CONSTRAINT FK_49C90026A76ED395 FOREIGN KEY (user_id) REFERENCES app_user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE app_user_product ADD CONSTRAINT FK_49C900264584665A FOREIGN KEY (product_id) REFERENCES app_product (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE app_user_product DROP CONSTRAINT FK_49C90026A76ED395');
        $this->addSql('ALTER TABLE app_user_product DROP CONSTRAINT FK_49C900264584665A');
        $this->addSql('DROP TABLE app_user_product');
    }
}
