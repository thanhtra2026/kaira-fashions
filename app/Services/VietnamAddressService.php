<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use UnexpectedValueException;

class VietnamAddressService
{
    private const BASE_URL = 'https://provinces.open-api.vn/api/v2';

    public function provinces(): array
    {
        return Cache::remember('vietnam-address:v2:provinces', now()->addDay(), function () {
            return $this->normalize($this->fetch('/p/'));
        });
    }

    public function wards(int $province): array
    {
        return Cache::remember("vietnam-address:v2:province:{$province}:wards", now()->addDay(), function () use ($province) {
            $data = $this->fetch("/p/{$province}", ['depth' => 2]);

            if (! is_array($data) || ($data['code'] ?? null) !== $province) {
                throw new UnexpectedValueException('Invalid province response.');
            }

            return $this->normalize($data['wards'] ?? null, $province);
        });
    }

    private function fetch(string $path, array $query = []): mixed
    {
        // Fixed upstream host. No customer name, phone or address is sent upstream.
        return Http::acceptJson()
            ->connectTimeout(2)
            ->timeout(5)
            ->get(self::BASE_URL . $path, $query)
            ->throw()
            ->json();
    }

    private function normalize(mixed $data, ?int $province = null): array
    {
        if (! is_array($data) || ! array_is_list($data) || $data === []) {
            throw new UnexpectedValueException('Invalid address list.');
        }

        $result = [];
        foreach ($data as $item) {
            if (! is_array($item)
                || ! is_int($item['code'] ?? null)
                || $item['code'] < 1
                || $item['code'] > ($province === null ? 99 : 99999)
                || ! is_string($item['name'] ?? null)
                || trim($item['name']) === ''
                || mb_strlen($item['name']) > 150
                || isset($result[$item['code']])
                || ($province !== null && ($item['province_code'] ?? null) !== $province)) {
                throw new UnexpectedValueException('Invalid address item.');
            }

            $result[$item['code']] = ['code' => $item['code'], 'name' => trim($item['name'])];
        }

        return array_values($result);
    }
}
