<?php

namespace App\Models\Admin\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class BaseModel extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Fill model attributes with the given data.
     */
    public function fillAttributes(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key === 'slug') {
                $this->slug = Str::slug($value);
            } elseif ($key === 'password') {
                $this->password = Hash::make($value);
            } else {
                $this->{$key} = $value;
            }
        }
    }
}
