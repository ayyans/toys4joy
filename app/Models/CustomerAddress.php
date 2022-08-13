<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'cust_id',
        'unit_no',
        'building_no',
        'zone',
        'street',
        'faddress'
    ];

    public function getFullAddressAttribute() {
        $address = '';
        $address .= $this->unit_no ? "Unit No: {$this->unit_no}" : '';
        $address .= $this->building_no ? ", Building No: {$this->building_no}" : '';
        $address .= $this->zone ? ", Zone: {$this->zone}" : '';
        $address .= $this->street ? ", Street: {$this->street}" : '';
        $address .= $this->latitude ? ", Latitude: {$this->latitude}" : '';
        $address .= $this->longitude ? ", Longitude: {$this->longitude}" : '';
        return $address;
    }
}
