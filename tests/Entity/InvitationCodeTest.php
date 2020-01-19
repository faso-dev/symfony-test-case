<?php


namespace App\Tests\Entity;


use App\Entity\Invitation;
use \Exception;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Class InvitationCodeTest
 * @package App\Tests\Entity
 */
class InvitationCodeTest extends KernelTestCase
{
    use FixturesTrait;
    /**
     * @return Invitation
     * @throws Exception
     */
    public function getEntity(): Invitation
    {
        return (new Invitation())
            ->setCode('12345')
            ->setDescription('Description du test')
            ->setExpireAt(new \DateTimeImmutable());
    }

    /**
     * @param Invitation $invitation
     * @return ConstraintViolationListInterface
     */
    public function assertGetErrors(Invitation $invitation)
    {
        self::bootKernel();
        return self::$container->get('validator')->validate($invitation);
    }

    /**
     * @param Invitation $invitation
     * @param int $expected_errors
     */
    public function assertHasErrors(Invitation $invitation, int $expected_errors = 0)
    {
        $this->assertCount($expected_errors,$this->assertGetErrors($invitation));
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testInValidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testInvalidEntityWithMultipleDataOfCode()
    {
        $this->setRepeatInValidCodeEntityDatas([
            '', 12345, "LL", "1111l"
        ], 3);
    }

    /**
     * @param array $invalid_code_datas
     * @param int $expected_errors
     * @throws Exception
     */
    public function setRepeatInValidCodeEntityDatas(array $invalid_code_datas, int $expected_errors )
    {
        $invitaion = $this->getEntity();
        $errors = [];
        foreach ($invalid_code_datas as $code_data){
            $invitaion->setCode($code_data);
            $error = $this->assertGetErrors($invitaion);
            if (count($error) > 0){
                $errors[] = $error;
            }
        }

        $this->assertCount($expected_errors, $errors);
    }

    /**
     * @throws Exception
     */
    public function testBlankCodeInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode(''), 1);
    }
    /**
     * @throws Exception
     */
    public function testBlankDescriptionInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(''), 1);
    }

    /**
     * @throws Exception
     */
    public function testminLengthDescriptionInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setDescription('Une'), 1);
    }
    /**
     * @throws Exception
     */
    public function testmaxLengthDescriptionInvalidEntity()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(str_repeat('f', 256)), 1);
    }

    /**
     * @throws Exception
     */
    public function testIsUniqueCodeInvalidEntity()
    {
        $this->loadFixtureFiles([dirname(__DIR__).'/DataFixtures/entity/InvitationCodeTestFixtures.yml']);
        $this->assertHasErrors($this->getEntity()->setCode('12345'),1);
    }
}
