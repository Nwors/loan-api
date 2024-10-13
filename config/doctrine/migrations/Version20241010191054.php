<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010191054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
        INSERT INTO app_product (id, name, loan_term, interest_rate, amount, created_at, updated_at)
            VALUES
            ('10eb998a-3631-ba57-2f22-4e029e1dda4c' , 'Product A', 12, 5.5, 10000.00, now(), now()),
            ('ba177f63-1ea6-ba38-70ef-f7f22d776c47' , 'Product B', 24, 4.0, 20000.00, now(), now());
        SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $this->addSql("delete from app_product where name = 'Product A' OR name = 'Product B'");
    }
}
