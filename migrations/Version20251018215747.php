<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251018215747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE clientes (id SERIAL NOT NULL, nombre VARCHAR(100) NOT NULL, documento NUMERIC(10, 2) NOT NULL, telefono NUMERIC(10, 2) NOT NULL, correo VARCHAR(100) DEFAULT NULL, direccion VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE pagos (id SERIAL NOT NULL, registro_id INT NOT NULL, monto NUMERIC(10, 2) NOT NULL, fecha_pago TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, metodo_pago VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA9B0DFF39C50FAE ON pagos (registro_id)');
        $this->addSql('CREATE TABLE registros (id SERIAL NOT NULL, hora_entrada TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, hora_salida TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, tiempo_total NUMERIC(10, 2) DEFAULT NULL, string VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE tarifas (id SERIAL NOT NULL, tipo_id INT NOT NULL, valor_hora NUMERIC(10, 2) NOT NULL, valor_dia NUMERIC(10, 2) NOT NULL, estado BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7A6F316DA9276E6C ON tarifas (tipo_id)');
        $this->addSql('CREATE TABLE tipos_vehiculos (id SERIAL NOT NULL, descripcion VARCHAR(100) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id SERIAL NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "user" (email)');
        $this->addSql('CREATE TABLE vehiculos (id SERIAL NOT NULL, cliente_id INT NOT NULL, tipo_id INT NOT NULL, placa VARCHAR(10) NOT NULL, color VARCHAR(50) DEFAULT NULL, marca VARCHAR(50) DEFAULT NULL, string VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_82CE64A7DE734E51 ON vehiculos (cliente_id)');
        $this->addSql('CREATE INDEX IDX_82CE64A7A9276E6C ON vehiculos (tipo_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE pagos ADD CONSTRAINT FK_DA9B0DFF39C50FAE FOREIGN KEY (registro_id) REFERENCES registros (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE tarifas ADD CONSTRAINT FK_7A6F316DA9276E6C FOREIGN KEY (tipo_id) REFERENCES tipos_vehiculos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vehiculos ADD CONSTRAINT FK_82CE64A7DE734E51 FOREIGN KEY (cliente_id) REFERENCES clientes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE vehiculos ADD CONSTRAINT FK_82CE64A7A9276E6C FOREIGN KEY (tipo_id) REFERENCES tipos_vehiculos (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pagos DROP CONSTRAINT FK_DA9B0DFF39C50FAE');
        $this->addSql('ALTER TABLE tarifas DROP CONSTRAINT FK_7A6F316DA9276E6C');
        $this->addSql('ALTER TABLE vehiculos DROP CONSTRAINT FK_82CE64A7DE734E51');
        $this->addSql('ALTER TABLE vehiculos DROP CONSTRAINT FK_82CE64A7A9276E6C');
        $this->addSql('DROP TABLE clientes');
        $this->addSql('DROP TABLE pagos');
        $this->addSql('DROP TABLE registros');
        $this->addSql('DROP TABLE tarifas');
        $this->addSql('DROP TABLE tipos_vehiculos');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE vehiculos');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
