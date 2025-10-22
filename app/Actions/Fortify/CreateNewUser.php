<?php

namespace App\Actions\Fortify;

use App\Actions\Shop\MigrateSessionCart;
use App\Models\Customer;
use Database\Factories\CartFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): Customer
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(Customer::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $customer = Customer::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => $input['phone'],
            'address' => $input['address'],
            'password' => Hash::make($input['password']),
        ]);

        // Migra il carrello anonimo verso l'utente appena creato
        (new MigrateSessionCart)->migrate(
            CartFactory::make(),
            $customer->cart ?: $customer->cart()->create()
        );

        return $customer;
    }
}
