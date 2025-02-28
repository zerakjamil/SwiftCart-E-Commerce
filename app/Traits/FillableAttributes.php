<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

trait FillableAttributes
{
    public function fillAttributes(array $data): void
    {
        foreach ($data as $key => $value) {
            if ($key === 'slug') {
                $this->slug = Str::slug($value);
            } elseif ($key === 'password') {
                $this->password = Hash::make($value);
            } elseif ($this->isDateTimeAttribute($key)) {
                $this->{$key} = $this->parseDateTime($value);
            } else {
                $this->{$key} = $value;
            }
        }
    }

    protected function isDateTimeAttribute($key): bool
    {
        $dateTimeFields = ['expiry_date', 'created_at', 'updated_at'];
        return in_array($key, $dateTimeFields);
    }

    protected function parseDateTime($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        try {
            $dateTime = Carbon::createFromFormat('Y-m-d\TH:i', $value);
        } catch (\Exception $e) {
            try {
                $dateTime = Carbon::parse($value);
            } catch (\Exception $e) {
                return $value;
            }
        }

        return $dateTime->format('Y-m-d H:i:s');
    }
}
