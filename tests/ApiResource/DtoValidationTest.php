<?php

namespace App\Tests\ApiResource;

use App\ApiResource\Dto\CodeBase\CodeBaseCreateDto;
use App\ApiResource\Dto\Priority\PriorityCreateDto;
use App\ApiResource\Dto\Status\StatusCreateDto;
use App\ApiResource\Dto\User\UserCreateDto;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class DtoValidationTest extends KernelTestCase
{
    private ValidatorInterface $validator;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->validator = self::getContainer()->get(ValidatorInterface::class);
    }

    public function testPriorityCreateDtoValidationMessages(): void
    {
        $dto = new PriorityCreateDto();
        // All NotBlank fields are empty

        $errors = $this->validator->validate($dto);

        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        $this->assertArrayHasKey('label', $messages);
        $this->assertEquals('Le label ne doit pas être vide.', $messages['label']);

        $this->assertArrayHasKey('priorityNumber', $messages);
        $this->assertEquals('Le numéro de priorité ne doit pas être vide.', $messages['priorityNumber']);

    }

    public function testStatusCreateDtoValidationMessages(): void
    {
        $dto = new StatusCreateDto();

        $errors = $this->validator->validate($dto);

        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        $this->assertArrayHasKey('label', $messages);
        $this->assertEquals('Le label ne doit pas être vide.', $messages['label']);

    }

    public function testUserCreateDtoValidationMessages(): void
    {
        $dto = new UserCreateDto();

        $errors = $this->validator->validate($dto);

        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        $this->assertEquals('Le prénom ne doit pas être vide.', $messages['firstName']);
        $this->assertEquals('Le nom ne doit pas être vide.', $messages['lastName']);
        $this->assertEquals('L\'email ne doit pas être vide.', $messages['email']);
    }

    public function testCodeBaseCreateDtoValidationMessages(): void
    {
        $dto = new CodeBaseCreateDto();

        $errors = $this->validator->validate($dto);

        $messages = [];
        foreach ($errors as $error) {
            $messages[$error->getPropertyPath()] = $error->getMessage();
        }

        $this->assertEquals('Le label ne doit pas être vide.', $messages['label']);
        $this->assertEquals('Le code ne doit pas être vide.', $messages['code']);
    }
}
