<?php

use Phalcon\Db\Exception;
use Phalcon\Migrations\Mvc\Model\Migration;

/**
 * Class OrganizationsMigration_100
 */
class ZzzForeignKeysMigration_100 extends Migration {
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
    self::$connection->execute('ALTER TABLE projects ADD CONSTRAINT fk_projects_organizations FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE tasks ADD CONSTRAINT fk_tasks_projects FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE organization_contacts ADD CONSTRAINT fk_organization_contact_organizations FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE memberships ADD CONSTRAINT fk_memberships_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE memberships ADD CONSTRAINT fk_memberships_organizations FOREIGN KEY (organization_id) REFERENCES organizations(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE assigned_project_members ADD CONSTRAINT fk_assigned_project_members_projects FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE assigned_project_members ADD CONSTRAINT fk_assigned_project_members_memberships FOREIGN KEY (membership_id) REFERENCES memberships(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE assigned_task_members ADD CONSTRAINT fk_assigned_task_members_tasks FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE');
    self::$connection->execute('ALTER TABLE assigned_task_members ADD CONSTRAINT fk_assigned_task_members_assigned_member FOREIGN KEY (assigned_member_id) REFERENCES assigned_project_members(id) ON DELETE CASCADE');
  }

  /**
   * Reverse the migrations
   *
   * @return void
   */
  public function down(): void {}
}
