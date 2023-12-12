<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use App\Filament\Resources\CustomerResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function afterCreate(): void
    {
        event(new \App\Events\PushPosData(0, 'new_customer_id', ['id' => $this->record->id, 'name' => $this->record->name, 'phone' => $this->record->mobile]));
    }
}
