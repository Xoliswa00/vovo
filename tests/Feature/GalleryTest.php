<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class GalleryTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_our_work_page_lists_only_published_projects(): void
    {
        Project::factory()->create(['title' => 'Steel Walkway Build']);
        Project::factory()->draft()->create(['title' => 'Secret Draft Project']);

        $this->get('/our-work')
            ->assertSee('Steel Walkway Build')
            ->assertDontSee('Secret Draft Project');
    }

    public function test_public_project_page_renders_for_published_and_404s_for_draft(): void
    {
        $published = Project::factory()->create();
        $draft     = Project::factory()->draft()->create();

        $this->get(route('projects.show.public', $published))->assertOk()->assertSee($published->title);
        $this->get(route('projects.show.public', $draft))->assertNotFound();
    }

    public function test_only_admins_can_manage_the_gallery(): void
    {
        $project  = Project::factory()->create();
        $customer = User::factory()->create(['role' => 'customer']);
        $vendor   = User::factory()->create(['role' => 'vendor']);

        foreach ([$customer, $vendor] as $user) {
            $this->actingAs($user)->get('/projects')->assertForbidden();
            $this->actingAs($user)->get('/projects/create')->assertForbidden();
            $this->actingAs($user)->get("/projects/{$project->slug}/edit")->assertForbidden();
        }

        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin)->get('/projects')->assertOk();
        $this->actingAs($admin)->get('/projects/create')->assertOk();
    }

    public function test_admin_can_create_a_project_with_photos(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post('/projects', [
            'title'        => 'Pressure Vessel Fabrication',
            'summary'      => 'A 5,000L ASME-coded vessel.',
            'category'     => 'Pressure Vessels',
            'is_published' => '1',
            'images'       => [UploadedFile::fake()->image('vessel.jpg')],
        ]);

        $response->assertRedirect(route('projects.index'));

        $project = Project::firstWhere('title', 'Pressure Vessel Fabrication');
        $this->assertNotNull($project);
        $this->assertSame('pressure-vessel-fabrication', $project->slug);
        $this->assertCount(1, $project->images);

        $image = $project->images->first();
        $this->assertTrue($image->is_primary);
        $this->assertStringStartsWith('assets/img/', $image->image_path);
        $this->assertFileExists(public_path($image->image_path));

        @unlink(public_path($image->image_path));
    }

    public function test_new_project_is_a_draft_until_explicitly_published(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->post('/projects', ['title' => 'Half-finished entry'])
            ->assertRedirect(route('projects.index'));

        $project = Project::firstWhere('title', 'Half-finished entry');
        $this->assertFalse($project->is_published);
        $this->get('/our-work')->assertDontSee('Half-finished entry');
    }

    public function test_slug_is_unique_across_projects(): void
    {
        $a = Project::factory()->create(['title' => 'Boiler Rebuild', 'slug' => null]);
        $b = Project::factory()->create(['title' => 'Boiler Rebuild', 'slug' => null]);

        $this->assertSame('boiler-rebuild', $a->fresh()->slug);
        $this->assertSame('boiler-rebuild-2', $b->fresh()->slug);
    }
}
