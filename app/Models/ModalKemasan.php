<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalKemasan extends Model
{
    protected $table = 'Kemasan';
    protected $primaryKey = 'IdKemasan';

    protected $allowedFields = [
        'IdKemasan',
        'IdProduk',
        'NamaKemasan',
        'Berat',
        'SatuanBerat',
        'Harga',
        'Stok',
        'Foto',
        'StatusKemasan'
    ];

    // =========================
    // GENERATE ID KEMASAN
    // =========================
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdKemasan, 4, 6)) AS nourut FROM Kemasan"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'KMS' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    // =========================
    // AMBIL DATA KEMASAN + NAMA PRODUK
    // =========================
    public function getKemasanWithProduk()
    {
        return $this->db->table('Kemasan')
            ->select('Kemasan.*, Produk.NamaProduk')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->orderBy('Kemasan.IdKemasan', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getKatalog()
    {
        return $this->db->table('Kemasan')
            ->select('
            Kemasan.*,
            Produk.NamaProduk,
            Produk.Deskripsi
        ')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->where('Produk.StatusProduk', 'Aktif')
            ->where('Kemasan.StatusKemasan', 'Aktif')
            ->orderBy('Produk.NamaProduk', 'ASC')
            ->get()
            ->getResultArray();
    }
}
