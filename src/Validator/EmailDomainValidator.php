<?php

namespace App\Validator;

use App\Repository\ConfigRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailDomainValidator extends ConstraintValidator
{
    /**
     * @var ConfigRepository
     */
    private $confr;
    /**
     * @var string
     */
    private $globalBlockedDomain;

    /**
     * EmailDomainValidator constructor.
     * @param ConfigRepository $confr
     * @param string $globalBlockedDomain
     */
    public function __construct(ConfigRepository $confr, string $globalBlockedDomain = '') {
        $this->confr = $confr;
        $this->globalBlockedDomain = explode(',', $globalBlockedDomain);
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint \App\Validator\EmailDomain */

        if (null === $value || '' === $value) {
            return;
        }

        $domain = substr($value, strpos($value, '@') + 1);
        $blockedDomain = array_merge(
            $constraint->blocked,
            $this->confr->getAsArray('blocked_domains'),
            $this->globalBlockedDomain
        );
        // TODO: implement the validation here
        if(in_array($domain, $blockedDomain)){
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }

    }
}
