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
            ->orderBy('IdPesanan', 'DESC')
            ->findAll();
    }

    public function getRiwayatPesanan($IdPelanggan, $status = 'Semua')
    {
        $builder = $this->db->table('Pesanan')
            ->where('IdPelanggan', $IdPelanggan);

        if ($status != 'Semua') {
            $builder->where('StatusPesanan', $status);
        }

        return $builder
            ->orderBy('TglPesanan', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getDetailPesanan($IdPesanan)
    {
        return $this->db->table('DetailPesanan')
            ->select('
            DetailPesanan.*,
            Produk.NamaProduk,
            Produk.Deskripsi,
            Kemasan.NamaKemasan,
            Kemasan.Berat,
            Kemasan.SatuanBerat,
            Kemasan.Foto
        ')
            ->join('Kemasan', 'Kemasan.IdKemasan = DetailPesanan.IdKemasan')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->where('IdPesanan', $IdPesanan)
            ->get()
            ->getResultArray();
    }
    public function getPembayaranTerakhir($IdPesanan)
    {
        return $this->db->table('Pembayaran')
            ->where('IdPesanan', $IdPesanan)
            ->orderBy('IdPembayaran', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function batalkanPesanan($IdPesanan)
    {
        return $this->update($IdPesanan, [
            'StatusPesanan' => 'Dibatalkan'
        ]);
    }
    public function cekSudahDP($IdPesanan)
    {
        return $this->db->table('Pembayaran')
            ->where('IdPesanan', $IdPesanan)
            ->where('JenisPembayaran', 'DP')
            ->where('StatusPembayaran', 'Terverifikasi')
            ->get()
            ->getRowArray();
    }
    public function cekSudahLunas($IdPesanan)
    {
        return $this->db->table('Pembayaran')
            ->groupStart()
            ->where('JenisPembayaran', 'Full Payment')
            ->orWhere('JenisPembayaran', 'Pelunasan')
            ->groupEnd()
            ->where('StatusPembayaran', 'Terverifikasi')
            ->where('IdPesanan', $IdPesanan)
            ->get()
            ->getRowArray();
    }
    public function getJumlahPembayaran($IdPesanan)
    {
        return $this->db->table('Pembayaran')
            ->selectSum('JumlahBayar')
            ->where('IdPesanan', $IdPesanan)
            ->where('StatusPembayaran', 'Terverifikasi')
            ->get()
            ->getRowArray();
    }
    public function getStatusPembayaran($IdPesanan)
    {
        return $this->db->table('Pembayaran')
            ->select('StatusPembayaran')
            ->where('IdPesanan', $IdPesanan)
            ->orderBy('IdPembayaran', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function getPesanan($IdPesanan)
    {
        return $this->db->table('Pesanan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan=Pesanan.IdPelanggan')
            ->where('IdPesanan', $IdPesanan)
            ->get()
            ->getRowArray();
    }

    public function getPembayaranByPesanan($idPesanan)
    {
        return $this->db->table('Pembayaran')
            ->where('IdPesanan', $idPesanan)
            ->orderBy('IdPembayaran', 'ASC')
            ->get()
            ->getResultArray();
    }
}
