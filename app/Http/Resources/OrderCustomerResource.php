<?php

namespace App\Http\Resources;

use App\Helpers\CodeHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderCustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'id_encode' => CodeHelper::encodeCode($this->id),
            'order_number' => $this->order_number,
            'order_number_encode' => CodeHelper::encodeCode($this->order_number),
            'order_type' => $this->order_type,
            'order_date' => $this->order_date,
            'order_date_format' => date('d F Y H:i', strtotime($this->order_date)),
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone_number' => $this->customer_phone_number,
            'notes' => $this->notes,
            'status' => $this->status,
            'approved_at' => $this->approved_at,
            'canceled_at' => $this->canceled_at,
            'approved_by' => $this->approved_by,
            'ccanceled_by_customer' => $this->ccanceled_by_customer,
            'ccanceled_by' => $this->ccanceled_by,
            'created_by_customer' => $this->created_by_customer,
            'created_by' => $this->created_by,
            'updated_by_customer' => $this->updated_by_customer,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'details' => $this->details,
        ];
    }
}
