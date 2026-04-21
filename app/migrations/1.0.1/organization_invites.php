<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrganizationInvitesMigration_101
 */
class OrganizationInvitesMigration_101 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {
    $this->morphTable('organization_invites', [
    ]);
  }

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
    $this->getConnection()->execute("
      CREATE TABLE organization_invites (
        invitee_user_id INTEGER NOT NULL,
        inviter_user_id INTEGER NOT NULL,
        organization_id INTEGER NOT NULL,
        created_at      TIMESTAMP NOT NULL DEFAULT NOW(),
        active          BOOLEAN NOT NULL DEFAULT TRUE,
        PRIMARY KEY (invitee_user_id, organization_id)
      )
    ");
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {
    $this->connection->execute('ALTER TABLE organization_invites DROP CONSTRAINT pk_organization_invites');
    $this->connection->execute('ALTER TABLE organization_invites DROP CONSTRAINT fk_invite_invitee');
    $this->connection->execute('ALTER TABLE organization_invites DROP CONSTRAINT fk_invite_inviter');
    $this->connection->execute('ALTER TABLE organization_invites DROP CONSTRAINT fk_invite_organization');
    $this->connection->dropTable("organization_invites");
  }
}
