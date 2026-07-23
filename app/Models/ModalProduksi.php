<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalProduksi extends Model
{
    protected $table = 'Produksi';
    protected $primaryKey = 'IdProduksi';

    protected $allowedFields = [
        'IdProduksi',
        'IdProduk',
        'TglProduksi',
        'JumlahProduksi',
        'HasilProduksi',
        'StatusProduksi',
        'StatusUpdateStok'
    ];

    // =====================================================
    // GENERATE ID PRODUKSI
    // =====================================================
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdProduksi, 4, 6)) AS nourut FROM Produksi"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'PRD' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    // =====================================================
    // JOIN PRODUKSI + PRODUK
    // =====================================================
    public function getProduksiWithProduk()
    {
        return $this->db->table('Produksi')
            ->select('Produksi.*, Produk.NamaProduk')
            ->join('Produk', 'Produk.IdProduk = Produksi.IdProduk')
            ->orderBy('Produksi.TglProduksi', 'DESC')
            ->get()
            ->getResultArray();
    }
}
