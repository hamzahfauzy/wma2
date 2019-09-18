<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $fillable = ['nama','jumlah_stok'];

    function keluars()
    {
    	return $this->hasMany(BarangKeluar::class,'barang_id','id');
    }
	
	function getStokAttribute()
	{
		$bk = $this->keluars()->sum('jumlah_keluar');
		return $this->jumlah_stok-$bk;
	}
}
