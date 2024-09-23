<?php

namespace App\Enum;

enum ResepStatus: int
{
    case BARU = 0;
    case DILAYANI = 1;

    public function statusName(): string
    {
        return match($this)
        {
        	self::BARU => 'Baru',
    	    self::DILAYANI => 'Resep dilayani',
        };
    }

    public static function getOptions(): array
    {
        $optStatus = [];
        foreach (self::cases() as $status) {
            $optStatus[] = [
                'label' => $status->statusName(),
                'code' => $status->value,
            ];
        }

        return $optStatus;
    }

    public static function fromName(string $name): string
    {
        foreach (self::cases() as $status) {
            if( $name === $status->name ){
                return $status->value;
            }
        }
        throw new \ValueError("$name is not a valid backing value for enum " . self::class );
    }
}
