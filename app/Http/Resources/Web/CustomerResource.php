<?php

namespace App\Http\Resources\Web;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'registration_package_id' => $this->registration_package_id,
            'package_price' => $this->package_price,
            'free_subscription_days' => $this->free_subscription_days,
            'package_subscribed_date' => $this->package_subscribed_date,
            'package_expiry_date' => $this->package_expiry_date,
            'is_package_amount_paid' => $this->is_package_amount_paid,
            'registration_package' => new RegistrationPackageResource($this->whenLoaded('registrationPackage')),
            'customer_business_categories' => CustomerBusinessCategoryResource::collection($this->whenLoaded('customerBusinessCategory')),
            'customer_media' => new CustomerMediaResource($this->whenLoaded('customerMedia')),
            'customer_profile' => new CustomerProfileResource($this->whenLoaded('customerProfile')),
            'customer_social_media' => new CustomerSocialMediaResource($this->whenLoaded('customerSocialMedia')),
        ];
    }
}
