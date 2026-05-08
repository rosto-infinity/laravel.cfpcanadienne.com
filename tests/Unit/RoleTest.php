<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\Role;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function test_roles_are_loaded_from_config(): void
    {
        $roles = Role::values();
        $this->assertIsArray($roles);
        $this->assertContains('user', $roles);
    }

    public function test_role_exists_validation(): void
    {
        $this->assertTrue(Role::exists('user'));
        $this->assertFalse(Role::exists('invalid_role'));
    }

    public function test_default_role_is_correct(): void
    {
        $defaultRole = Role::default();
        $this->assertEquals(config('roles.default'), $defaultRole->value);
    }

    public function test_superadmin_role_is_correct(): void
    {
        $superadminRole = Role::superadmin();
        $this->assertEquals(config('roles.superadmin'), $superadminRole->value);
    }

    public function test_role_hierarchy(): void
    {
        $this->assertGreaterThan(
            Role::ADMIN->level(),
            Role::superadmin()->level()
        );
    }
}
