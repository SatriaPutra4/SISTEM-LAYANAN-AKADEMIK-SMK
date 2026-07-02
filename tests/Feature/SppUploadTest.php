<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Siswa;
use App\Models\TagihanSpp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class SppUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_upload_bukti_pembayaran()
    {
        Storage::fake('public');

        $user = User::factory()->create(['role' => 'siswa']);
        $siswa = Siswa::factory()->create(['user_id' => $user->id]);
        $tagihan = TagihanSpp::factory()->create(['siswa_id' => $siswa->id]);

        $this->actingAs($user);

        $file = UploadedFile::fake()->image('bukti.jpg');

        Livewire::test(\App\Livewire\SiswaRole\Spp::class)
            ->call('openModal', $tagihan->id)
            ->set('bukti_pembayaran', $file)
            ->set('nominal_transfer', 100000)
            ->set('tanggal_transfer', now()->format('Y-m-d\TH:i'))
            ->call('uploadBukti');

        Storage::disk('public')->assertExists('bukti-spp/' . $file->hashName());
    }
}
