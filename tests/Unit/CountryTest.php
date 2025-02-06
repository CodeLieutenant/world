<?php

declare(strict_types=1);

namespace Nnjeim\World\Tests\Unit;

use Nnjeim\World\Actions\City;
use Nnjeim\World\Actions\Country;
use Nnjeim\World\Actions\Currency;
use Nnjeim\World\Actions\State;
use Nnjeim\World\Actions\Timezone;
use Nnjeim\World\Actions\Language;
use Nnjeim\World\Tests\TestCase;
use Symfony\Component\HttpFoundation\Response;

class CountryTest extends TestCase
{
    public function test_can_respond_with_countries(): void
    {
        $action = app(Country\IndexAction::class)->execute();

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_country(): void
    {
        $action = app(Country\IndexAction::class)->execute([
            'filters' => [
                'iso2' => 'FR',
            ],
        ]);

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_states(): void
    {
        $action = app(State\IndexAction::class)->execute([
            'filters' => [
                'country_id' => 182,
            ],
        ]);

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_cities(): void
    {
        $action = app(City\IndexAction::class)->execute([
            'filters' => [
                'country_id' => 182,
            ],
        ]);

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_timezones(): void
    {
        $action = app(Timezone\IndexAction::class)->execute([
            'filters' => [
                'country_id' => 182,
            ],
        ]);

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_currencies(): void
    {
        $action = app(Currency\IndexAction::class)->execute([
            'filters' => [
                'country_id' => 182,
            ],
        ]);

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }

    public function test_can_respond_with_languages(): void
    {
        $action = app(Language\IndexAction::class)->execute();

        self::assertTrue($action->success);
        self::assertNotEmpty($action->data);
//        self::assertSame($action->statusCode, Response::HTTP_OK);
    }
}
