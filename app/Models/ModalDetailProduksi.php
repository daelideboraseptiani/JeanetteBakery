<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalDetailProduksi extends Model
{
    protected $table = 'DetailProduksi';
    protected $primaryKey = 'IdDetailProduksi';

    protected $allowedFields = [
        'IdDetailProduksi',
        'IdProduksi',
        'IdBahanBaku',
        'QtyDipakai'
    ];

    // =====================================================
    // GENERATE ID DETAIL PRODUKSI
    // =====================================================
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdDetailProduksi, 4, 6)) AS nourut FROM DetailProduksi"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'DPR' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }
}
