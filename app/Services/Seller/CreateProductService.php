<?php

namespace App\Services\Seller;

use App\Exceptions\AppError;
use App\Models\Product;
use Tymon\JWTAuth\Facades\JWTAuth;

class CreateProductService
{
    public function execute(array $data, string $token)
    {
        
        $jwtToken = new \Tymon\JWTAuth\Token($token);

        $payload = JWTAuth::decode($jwtToken);

        $type = $payload->get('type');
        $id = $payload->get('id');

        if ($type == 'ADMINISTRADOR' || $type == 'VENDEDOR') {
            $data['seller_id'] = $id;

            if ($data['stock'] > 0) {
                $data['status'] = 'DISPONIVEL';
            } else {
                $data['status'] = 'INDISPONIVEL';
            }

            $user = Product::create($data);
            return $user->toArray();
        } else {
            throw new AppError("Apenas administrador e vendedor podem criar novos produtos.", 403);
        }
    }
}
