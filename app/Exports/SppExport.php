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
        return TagihanSpp::with(['siswa.user', 'siswa.kelas', 'pembayaranSpps'])->get();
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Tahun Ajaran',
            'Nominal',
            'Status',
            'Tanggal Pembayaran Terakhir',
        ];
    }

    public function map($tagihan): array
    {
        // Ambil tanggal pembayaran terakhir yang statusnya disetujui (atau semua)
        $latestPayment = $tagihan->pembayaranSpps->sortByDesc('tanggal_bayar')->first();
        $tanggal = $latestPayment ? $latestPayment->tanggal_bayar->format('d/m/Y H:i') : '-';

        return [
            $tagihan->siswa->user->name,
            $tagihan->siswa->kelas->nama_kelas ?? '-',
            $tagihan->tahun_ajaran,
            $tagihan->nominal,
            $tagihan->status,
            $tanggal,
        ];
    }
}
