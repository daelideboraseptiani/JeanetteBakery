<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalKeranjang extends Model
{
    protected $table            = 'Keranjang';
    protected $primaryKey       = 'IdKeranjang';

    protected $allowedFields = [
        'IdPelanggan',
        'IdKemasan',
        'Tanggal',
        'Qty',
        'Harga',
        'SubTotal',
        'Status'
    ];

    /**
     * Menampilkan isi keranjang berdasarkan pelanggan
     */
    public function getKeranjang($IdPelanggan)
    {
        return $this->db->table('Keranjang')
            ->select('
            Keranjang.*,
            Produk.NamaProduk,
            Produk.Deskripsi,
            Kemasan.NamaKemasan,
            Kemasan.Berat,
            Kemasan.SatuanBerat,
            Kemasan.Foto
        ')
            ->join('Kemasan', 'Kemasan.IdKemasan = Keranjang.IdKemasan')
            ->join('Produk', 'Produk.IdProduk = Kemasan.IdProduk')
            ->where('Keranjang.IdPelanggan', $IdPelanggan)
            ->where('Keranjang.Status', 'Aktif')
            ->orderBy('Keranjang.IdKeranjang', 'DESC')
            ->get()
            ->getResultArray();
    }

    /**
     * Menghitung total belanja di keranjang
     */
    public function totalKeranjang($IdPelanggan)
    {
        return $this->db->table('Keranjang')
            ->selectSum('SubTotal')
            ->where('IdPelanggan', $IdPelanggan)
            ->where('Status', 'Aktif')
            ->get()
            ->getRowArray();
    }

    /**
     * Mengecek apakah produk sudah ada di keranjang
     */
    public function cekKeranjang($IdPelanggan, $IdKemasan)
    {
        return $this->db->table('Keranjang')
            ->where('IdPelanggan', $IdPelanggan)
            ->where('IdKemasan', $IdKemasan)
            ->where('Status', 'Aktif')
            ->get()
            ->getRowArray();
    }

    public function tambahQty($IdKeranjang)
    {
        $keranjang = $this->find($IdKeranjang);

        if ($keranjang) {

            $qty = $keranjang['Qty'] + 1;

            $this->update($IdKeranjang, [
                'Qty' => $qty,
                'SubTotal' => $qty * $keranjang['Harga']
            ]);
        }
    }

    public function kurangQty($IdKeranjang)
    {
        $keranjang = $this->find($IdKeranjang);

        if ($keranjang) {

            if ($keranjang['Qty'] > 1) {

                $qty = $keranjang['Qty'] - 1;

                $this->update($IdKeranjang, [
                    'Qty' => $qty,
                    'SubTotal' => $qty * $keranjang['Harga']
                ]);
            }
        }
    }

    public function hapusKeranjang($IdKeranjang)
    {
        return $this->delete($IdKeranjang);
    }
}
