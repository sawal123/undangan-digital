<?php

namespace Database\Factories;

use App\Models\Data;
use App\Models\EventType;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DataFactory extends Factory
{
    protected $model = Data::class;

    public function definition(): array
    {
        $title = fake()->words(3, true);

        return [
            'user_id' => User::factory(),
            'theme_id' => null,
            'event_type_id' => EventType::query()->where('key', 'wedding')->value('id'),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'uid' => Str::lower(Str::random(6)),
            'isActive' => false,
        ];
    }

    public function active(): static
    {
        return $this->state(fn () => ['isActive' => true])
            ->afterCreating(function (Data $data): void {
                Transaction::factory()
                    ->for($data)
                    ->create([
                        'user_id' => $data->user_id,
                        'payment_status' => Transaction::STATUS_SUCCESS,
                    ]);
            });
    }
}
