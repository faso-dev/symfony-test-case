<?php


namespace App\Tests\Validator;


use App\Repository\ConfigRepository;
use App\Validator\EmailDomain;
use App\Validator\EmailDomainValidator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class EmailDomainValidatorTest extends TestCase
{
    /**
     * @param bool $expectedViolation
     * @return MockObject
     */
    private function getContext(bool $expectedViolation): MockObject
    {
        $context = $this->getMockBuilder(ExecutionContextInterface::class)
            ->getMock();
        if ($expectedViolation){
            $violation = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)
                ->getMock();
            $violation
                ->expects($this->any())
                ->method('setParameter')
                ->willReturn($violation);
            $violation
                ->expects($this->once())
                ->method('addViolation');
            $context
                ->expects($this->once())
                ->method('buildViolation')
                ->willReturn($violation);
        }else{
            $context
                ->expects($this->never())
                ->method('buildViolation');
        }

        return $context;
    }
    /**
     * @param bool $expectedViolation
     * @param array $dbBlockDomain
     * @return EmailDomainValidator
     */
    public function getValidator(bool $expectedViolation = false, array $dbBlockDomain = [])
    {
        $repository = $this->getMockBuilder(ConfigRepository::class)
            ->disableOriginalConstructor()
            ->getMock();
        $repository
            ->expects($this->any())
            ->method('getAsArray')
            ->with('blocked_domains')
            ->willReturn($dbBlockDomain);

        $validator = new EmailDomainValidator($repository);
        $context = $this->getContext($expectedViolation);
        $validator->initialize($context);
        return $validator;
    }
    public function testCatchBadDomains()
    {
        $constraint = new EmailDomain([
                'blocked' => ['baddomain.fr', 'aze.com']
            ]
        );
        $this->getValidator(true)->validate('demo@baddomain.fr', $constraint);
    }

    public function testAccepGoodDomains()
    {
        $constraint = new EmailDomain([
                'blocked' => ['baddomain.fr', 'aze.com']
            ]
        );
        $this->getValidator(false)
            ->validate('demo@faso-dev.fr', $constraint);
    }

    public function testBlockedDomainFromDatabase()
    {
        $constraint = new EmailDomain([
                'blocked' => ['baddomain.fr', 'aze.com']
            ]
        );
        $this->getValidator(true, ['baddomain.fr'])->validate('demo@baddomain.fr', $constraint);
    }

/*    public function testParametersSetCorrectly()
    {
        $constraint = new EmailDomain(['blocked' => []]);
        self::bootKernel();
        $validator = self::$container->get(EmailDomainValidator::class);
        $validator->initialize($this->getContext(true));
        $validator->validate('demo@test.fr', $constraint);
    }*/
}
