<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalDetailPesanan extends Model
{
    protected $table      = 'DetailPesanan';
    protected $primaryKey = 'IdDetailPesanan';

    protected $allowedFields = [
        'IdDetailPesanan',
        'IdPesanan',
        'IdKemasan',
        'Qty',
        'Harga',
        'SubTotal'
    ];

    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdDetailPesanan, 4, 6)) AS nourut FROM DetailPesanan"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'DPS' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }
}
