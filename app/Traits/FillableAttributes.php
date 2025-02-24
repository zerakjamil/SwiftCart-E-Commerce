<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

trait FillableAttributes
{
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
