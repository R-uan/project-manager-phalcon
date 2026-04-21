<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrganizationsMigration_100
 */
class ZzzForeignKeysMigration_101 extends Migration {
  /**
   * Define the table structure
   *
   * @return void
   * @throws Exception
   */
  public function morph(): void {}

  /**
   * Run the migrations
   *
   * @return void
   */
  public function up(): void {
    self::$connection->execute('ALTER TABLE organization_invites ADD CONSTRAINT fk_invite_invitee FOREIGN KEY (invitee_user_id) REFERENCES public.users(id)');
    self::$connection->execute('ALTER TABLE organization_invites ADD CONSTRAINT fk_invite_inviter FOREIGN KEY (inviter_user_id) REFERENCES public.users(id)');
    self::$connection->execute('ALTER TABLE organization_invites ADD CONSTRAINT fk_invite_organization FOREIGN KEY (organization_id) REFERENCES public.organizations(id)');
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {}
}
