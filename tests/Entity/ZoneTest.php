<?php

namespace App\Tests\Entity;

use App\Entity\Zone;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ZoneTest extends KernelTestCase 
{

    public function getEntity()
    {
        return (new Zone())
            ->setPage("Accueil")
            ->setLibelle("Introduction")
            ->setUrl("/accueil/introduction")
            ->setCreatedAt(new DateTime())
            ->setActive(true)
            ->setSiteweb("testweb")
            ->setCreatedBy("1")
        ;
    }

    public function assertHasErrors(Zone $zone, int $number = 0)
    {
        self::bootKernel();
        $errors = self::$container->get("validator")->validate($zone);

        $messages = [];
        /** var ConstraintViolation $error */
        foreach($errors as $error){
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(", ", $messages));
    }

    public function testValideEntity() 
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalideEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setUrl("/t"), 1);
    }

    public function testInvalideBlankEntity() 
    {
        $this->assertHasErrors($this->getEntity()->setPage(""), 2);
    }

}