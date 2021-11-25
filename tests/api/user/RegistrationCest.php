<?php

namespace App\Tests;

use App\Entity\User;

use App\Tests\ApiTester;
use Codeception\Util\HttpCode;
use Faker\Factory;
use Faker\Generator;

class RegistrationCest
{
    private Generator $faker;

    public function _before(ApiTester $I)
    {
        $this->faker = Factory::create();
    }

    // --- successful tests ---
    public function registerSuccessfully(ApiTester $I)
    {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();
        $email = $this->faker->email();

        $I->sendPost("/register", [
            "firstName" => $firstName,
            "lastName" => $lastName,
            "email" => $email,
            "password" => $this->faker->password(),
        ]);

        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"message":"User registered successfully!"');
        $I->canSeeInRepository(User::class, [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email
        ]);
    }

    // --- fail tests ---
    public function registerWithoutFirstName(ApiTester $I)
    {
        $I->sendPost("/register", [
            "lastName" => $this->faker->lastName(),
            "email" => $this->faker->email(),
            "password" => $this->faker->password(),
        ]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"error":"First name is required!"');
    }

    public function registerWithoutLastName(ApiTester $I)
    {
        $I->sendPost("/register", [
            "firstName" => $this->faker->firstName(),
            "email" => $this->faker->email(),
            "password" => $this->faker->password(),
        ]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"error":"Last name is required!"');
    }

    public function registerWithoutEmail(ApiTester $I)
    {
        $I->sendPost("/register", [
            "firstName" => $this->faker->firstName(),
            "lastName" => $this->faker->lastName(),
            "password" => $this->faker->password(),
        ]);

        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        $I->seeResponseContains('"error":"Email is required!"');
    }
}
