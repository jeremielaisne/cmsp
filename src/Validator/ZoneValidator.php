<?php

namespace App\Validator;

use App\Repository\ZoneRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ZoneValidator extends ConstraintValidator
{
    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    public function validate($value, Constraint $constraint)
    {
        $existingZone = $this->zoneRepository->findOneBy([
            "libelle" => $value
        ]);

        if (!$existingZone) {
            return;
        }

        /* @var $constraint \App\Validator\Zone */

        if (null === $value || '' === $value || !$existingZone) {
            return;
        }

        // TODO: implement the validation here
        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
