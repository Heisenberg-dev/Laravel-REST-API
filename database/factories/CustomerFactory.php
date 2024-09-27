<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Customer;
use App\Models\Invoice;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     
        @var string

        protected $model = Customer::class;

        @return array
     */
    public function definition()
    {
        $type = $this->faker->randomElement(['I','B']); // Individual , Buisiness
        $name = $type == 'I' ? $this->faker->name(): $this->faker->company();
        return [
            'name' =>  $name,
            'type' => $type,
            'email' => $this->faker->email(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode()
        ];
    }

    public function hasInvoices(int $count)
    {
        return $this->has(
            Invoice::factory()->count($count),
            'invoices'
        );
    }
}
