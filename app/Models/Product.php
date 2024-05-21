<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'currency',
    ];
    
    protected $hidden = ['created_at', 'updated_at'];

    protected function casts(): array
    {
        return [
            'price' => 'int',
        ];
    }

    /**
     */
    protected function currency(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtoupper($value),
            set: fn (string $value) => strtoupper(substr($value,0,3)),
        );
    }



    /**
     * Save the model to the database.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (is_numeric($this->price)) {
            return parent::save($options);
        }
        return false;
    }

}
