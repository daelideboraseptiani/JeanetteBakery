<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalProduk extends Model
{
    protected $table = 'Produk';
    protected $primaryKey = 'IdProduk';

    protected $allowedFields = [
        'IdProduk',
        'NamaProduk',
        'Deskripsi',
        'StatusProduk'
    ];

    public function generateId()
    {
        $query = $this->db->query("SELECT MAX(SUBSTRING(IdProduk, 4, 6)) AS nourut FROM Produk");
        $row = $query->getRowArray();
        $nourut = (int)$row['nourut'] + 1;
        return 'PRD' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    public function getKategori()
{
    return $this->table('Produk')
        ->where('StatusProduk', 'Aktif')
        ->orderBy('NamaProduk', 'ASC')
        ->findAll();
}
}
