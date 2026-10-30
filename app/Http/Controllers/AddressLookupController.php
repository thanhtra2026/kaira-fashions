<?php

namespace App\Http\Controllers;

use App\Services\VietnamAddressService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use UnexpectedValueException;

class AddressLookupController extends Controller
{
    public function provinces(VietnamAddressService $addresses): JsonResponse
    {
        return $this->respond(fn () => $addresses->provinces());
    }

    public function wards(string $province, VietnamAddressService $addresses): JsonResponse
    {
        return $this->respond(fn () => $addresses->wards((int) $province));
    }

    private function respond(callable $lookup): JsonResponse
    {
        try {
            return response()->json(['data' => $lookup()]);
        } catch (RequestException $exception) {
            if ($exception->response->status() === 404) {
                return response()->json(['message' => 'Không tìm thấy địa phương này.'], 404);
            }

            return $this->unavailable();
        } catch (ConnectionException | UnexpectedValueException $exception) {
            return $this->unavailable();
        }
    }

    private function unavailable(): JsonResponse
    {
        return response()->json([
            'message' => 'Chưa tải được danh sách địa phương. Bạn vẫn có thể nhập địa chỉ đầy đủ bên dưới.',
        ], 503, ['Retry-After' => '60']);
    }
}
