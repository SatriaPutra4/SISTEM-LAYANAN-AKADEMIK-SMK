<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Imports\SiswaImport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Maatwebsite\Excel\Facades\Excel;
use Tests\TestCase;

class SiswaImportTest extends TestCase
{
    use RefreshDatabase;

    public function test_import_siswa_via_excel_or_csv()
    {
        Excel::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->create('siswa.xlsx');

        $this->actingAs($admin);

        Livewire::test(\App\Livewire\Siswa\Index::class)
            ->set('file', $file)
            ->call('import');

        Excel::assertImported('siswa.xlsx', null, function(SiswaImport $import) {
            return true;
        });
    }
}
