<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'status'       => $this->status,
            'subtotal'     => $this->subtotal,
            'shipping'     => $this->shipping_total,
            'tax'          => $this->tax_total,
            'total'        => $this->total,
            'payment'      => $this->payment_method,
            'notes'        => $this->notes,
            'created_at'   => $this->created_at,
            'customer'     => $this->when(
                $this->user,
                [
                    'id'    => $this->user->id,
                    'name'  => $this->user->name,
                    'email' => $this->user->email,
                ],
                [
                    'name'  => $this->guest_name,
                    'email' => $this->guest_email,
                    'phone' => $this->guest_phone,
                ]
            ),
            'address'      => $this->when(
                $this->relationLoaded('shippingAddress') || $this->relationLoaded('address'),
                function () {
                    $address = $this->relationLoaded('shippingAddress') 
                        ? $this->shippingAddress 
                        : ($this->relationLoaded('address') ? $this->address : null);
                    return $address ? new AddressResource($address) : null;
                }
            ),
            'items'        => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
