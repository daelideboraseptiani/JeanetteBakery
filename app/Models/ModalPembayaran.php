<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalPembayaran extends Model
{
    protected $table      = 'Pembayaran';
    protected $primaryKey = 'IdPembayaran';

    protected $allowedFields = [
        'IdPembayaran',
        'IdPesanan',
        'TglBayar',
        'JumlahBayar',
        'JenisPembayaran',
        'MetodePembayaran',
        'StatusPembayaran',
        'BuktiPembayaran'
    ];

    // =====================================================
    // GENERATE ID
    // =====================================================
    public function generateId()
    {
        $query = $this->db->query(
            "SELECT MAX(SUBSTRING(IdPembayaran, 4, 6)) AS nourut FROM Pembayaran"
        );

        $row = $query->getRowArray();

        $nourut = (int) ($row['nourut'] ?? 0) + 1;

        return 'BYR' . str_pad($nourut, 6, '0', STR_PAD_LEFT);
    }

    // =====================================================
    // DATA PEMBAYARAN LENGKAP
    // =====================================================
    public function getPembayaranLengkap()
    {
        $data = $this->select('
Pembayaran.*,
Pesanan.Total,
Pesanan.StatusPesanan,
Pelanggan.NamaPelanggan
')
            ->join('Pesanan', 'Pesanan.IdPesanan = Pembayaran.IdPesanan')
            ->join('Pelanggan', 'Pelanggan.IdPelanggan = Pesanan.IdPelanggan')
            ->orderBy('Pembayaran.IdPembayaran  ', 'DESC')
            ->findAll();


        // =====================================================
        // TAMBAHKAN STATUS PELUNASAN
        // =====================================================
        foreach ($data as &$row) {

            $idPesanan = $row['IdPesanan'];

            // Full Payment terverifikasi
            $fullPayment = $this->where('IdPesanan', $idPesanan)
                ->where('JenisPembayaran', 'Full Payment')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            // Pelunasan terverifikasi
            $pelunasan = $this->where('IdPesanan', $idPesanan)
                ->where('JenisPembayaran', 'Pelunasan')
                ->where('StatusPembayaran', 'Terverifikasi')
                ->first();

            // Tentukan status
            if ($fullPayment || $pelunasan) {

                $row['StatusPelunasan'] = 'Lunas';
            } else {

                $row['StatusPelunasan'] = 'Belum Lunas';
            }
        }

        return $data;
    }


    // =====================================================
    // TOTAL PEMBAYARAN TERVERIFIKASI PER PESANAN
    // =====================================================
    public function getTotalTerverifikasi($IdPesanan)
    {
        $result = $this->selectSum('JumlahBayar')
            ->where('IdPesanan', $IdPesanan)
            ->where('StatusPembayaran', 'Terverifikasi')
            ->get()
            ->getRowArray();

        return (float) ($result['JumlahBayar'] ?? 0);
    }

    // =====================================================
    // CEK APAKAH SUDAH ADA FULL PAYMENT
    // =====================================================
    public function sudahFullPayment($IdPesanan)
    {
        return $this->where('IdPesanan', $IdPesanan)
            ->where('JenisPembayaran', 'Full Payment')
            ->where('StatusPembayaran', 'Terverifikasi')
            ->first();
    }

    // =====================================================
    // CEK APAKAH SUDAH ADA PELUNASAN
    // =====================================================
    public function sudahPelunasan($IdPesanan)
    {
        return $this->where('IdPesanan', $IdPesanan)
            ->where('JenisPembayaran', 'Pelunasan')
            ->where('StatusPembayaran', 'Terverifikasi')
            ->first();
    }
}
