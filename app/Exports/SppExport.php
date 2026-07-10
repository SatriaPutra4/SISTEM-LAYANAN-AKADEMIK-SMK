<?php

namespace App\Exports;

use App\Models\TagihanSpp;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class SppExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return TagihanSpp::with(['siswa.user', 'siswa.kelas'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Tahun Ajaran',
            'Nominal',
            'Status',
            'Tanggal Pembayaran',
        ];
    }

    public function map($tagihan): array
    {
        return [
            $tagihan->siswa->user->name,
            $tagihan->siswa->kelas->nama_kelas ?? '-',
            $tagihan->tahun_ajaran,
            $tagihan->nominal,
            $tagihan->status,
            $tagihan->tanggal_pembayaran ?? '-',
        ];
    }
}
