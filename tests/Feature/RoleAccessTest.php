<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_cannot_reach_admin_only_routes(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get('/vendors')->assertForbidden();
        $this->actingAs($customer)->get('/vehicles')->assertForbidden();
        $this->actingAs($customer)->get('/orders')->assertForbidden();
        $this->actingAs($customer)->get('/categories')->assertForbidden();
    }

    public function test_customer_cannot_reach_catalog_management(): void
    {
        $customer = User::factory()->create(['role' => 'customer']);

        $this->actingAs($customer)->get('/products')->assertForbidden();
        $this->actingAs($customer)->get('/services')->assertForbidden();
    }

    public function test_vendor_cannot_reach_admin_only_routes(): void
    {
        $vendor = User::factory()->create(['role' => 'vendor']);

        $this->actingAs($vendor)->get('/vendors')->assertForbidden();
        $this->actingAs($vendor)->get('/vehicles')->assertForbidden();
        $this->actingAs($vendor)->get('/orders')->assertForbidden();
    }

    public function test_vendor_can_manage_only_their_own_products(): void
    {
        $vendorA = User::factory()->create(['role' => 'vendor']);
        $vendorProfileA = Vendor::factory()->create(['user_id' => $vendorA->id]);

        $vendorB = User::factory()->create(['role' => 'vendor']);
        $vendorProfileB = Vendor::factory()->create(['user_id' => $vendorB->id]);

        $productB = Product::factory()->create(['vendor_id' => $vendorProfileB->id]);

        // Vendor A cannot edit/delete Vendor B's product.
        $this->actingAs($vendorA)->get("/products/{$productB->id}/edit")->assertForbidden();
        $this->actingAs($vendorA)->delete("/products/{$productB->id}")->assertForbidden();

        // Vendor B can edit their own product.
        $this->actingAs($vendorB)->get("/products/{$productB->id}/edit")->assertOk();
    }

    public function test_admin_can_reach_everything(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->get('/dashboard')->assertOk();
        $this->actingAs($admin)->get('/vendors')->assertOk();
        $this->actingAs($admin)->get('/products')->assertOk();
        $this->actingAs($admin)->get('/services')->assertOk();
    }
}
