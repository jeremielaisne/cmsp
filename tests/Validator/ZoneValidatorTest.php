<?php

namespace App\Tests\Validator;

use App\Validator\Zone;
use PHPUnit\Framework\TestCase;
use Symfony\Component\OptionsResolver\Exception\MissingOptionsException;

class ZoneValidatorTest extends TestCase 
{
    
    public function testRequiredParameters() 
    {
        $this->expectException(MissingOptionsException::class);
        new Zone();
    }
}