<?php

namespace App\Enums\Shop;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasColor, HasLabel
{
    case Pending = 'pending';
    case OnHold = 'on-hold';
    case Processing = 'processing';
    case Completed = 'completed';
    case Refunded = 'refunded';
    case Failed = 'failed';
    case Cancelled = 'cancelled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => __('Pending'),
            self::OnHold => __('On Hold'),
            self::Processing => __('Processing'),
            self::Completed => __('Completed'),
            self::Refunded => __('Refunded'),
            self::Failed => __('Failed'),
            self::Cancelled => __('Cancelled'),
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Pending => 'gray',
            self::OnHold => 'warning',
            self::Processing => 'info',
            self::Completed => 'success',
            self::Refunded => 'info',
            self::Failed => 'danger',
            self::Cancelled => 'gray',
        };
    }
}
