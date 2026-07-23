<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalPesanan extends Model
{
    protected $table      = 'Pesanan';
    protected $primaryKey = 'IdPesanan';

    protected $allowedFields = [
        'IdPesanan',
        'IdPelanggan',
        'TglPesanan',
        'StatusPesanan',
        'EstimasiSelesai',
        'Total'
    ];

    // Generate ID otomatis
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdPesanan, 4, 6)) AS nourut FROM Pesanan"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'PSN' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    // Join pelanggan
    public function getPesananWithPelanggan()
    {
        return $this->select('Pesanan.*, Pelanggan.NamaPelanggan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->orderBy('TglPesanan', 'DESC')
            ->findAll();
    }
}
