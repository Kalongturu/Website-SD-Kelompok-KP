<?php

namespace Tests\Feature;

use App\Models\KalenderAkademik;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KalenderAkademikTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'url' => null,
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => true,
            'busy_timeout' => null,
            'journal_mode' => null,
            'synchronous' => null,
            'transaction_mode' => 'DEFERRED',
        ]);

        DB::purge();
        $this->artisan('migrate:fresh', ['--force' => true])->assertExitCode(0);
    }

    public function test_admin_can_manage_calendar_document_and_public_can_view_it(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.kalender-akademik.store'), [
            'tahun_ajaran' => '2026-2027',
            'file' => UploadedFile::fake()->create('kalender-2026.pdf', 100, 'application/pdf'),
            'urutan' => 1,
            'is_active' => '1',
        ]);

        $response->assertRedirect(route('admin.kalender-akademik.index'));

        $item = KalenderAkademik::firstOrFail();
        $this->assertSame('2026/2027', $item->tahun_ajaran);
        $this->assertTrue($item->is_active);
        Storage::disk('public')->assertExists($item->file_path);

        $this->get(route('admin.kalender-akademik.index'))
            ->assertOk()
            ->assertSee('2026/2027');

        $this->put(route('admin.kalender-akademik.update', $item), [
            'tahun_ajaran' => '2026/2027',
            'urutan' => 2,
        ])->assertRedirect(route('admin.kalender-akademik.index'));

        $item->refresh();
        $this->assertSame(2, $item->urutan);
        $this->assertFalse($item->is_active);

        $this->patch(route('admin.kalender-akademik.toggle', $item))->assertRedirect();
        $this->assertTrue($item->fresh()->is_active);

        Auth::logout();
        $this->get(route('akademik.kalender'))
            ->assertOk()
            ->assertSee('KALDIK TP 2026/2027');

        $this->actingAs($admin)
            ->delete(route('admin.kalender-akademik.destroy', $item))
            ->assertRedirect();

        $this->assertDatabaseMissing('kalender_akademik_dokumen', ['id' => $item->id]);
        Storage::disk('public')->assertMissing($item->file_path);
    }

    public function test_calendar_requires_valid_year_and_supported_file(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $this->actingAs($admin)
            ->from(route('admin.kalender-akademik.create'))
            ->post(route('admin.kalender-akademik.store'), [
                'tahun_ajaran' => 'tahun depan',
                'file' => UploadedFile::fake()->create('kalender.docx', 100),
            ])
            ->assertRedirect(route('admin.kalender-akademik.create'))
            ->assertSessionHasErrors(['tahun_ajaran', 'file']);
    }
}
