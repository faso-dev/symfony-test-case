<?php


namespace App\Tests\Validator;


use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

class EmailDomainTest extends TestCase
{
    public function testRequiredParameters()
    {
        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapedBlockedParameter()
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => 'azzzeea']);
    }

    public function testOptionIsSetAsProperty()
    {
        $block_domain = ['a', 'b'];
        $domain = new EmailDomain(['blocked' => $block_domain]);
        $this->assertEquals($block_domain, $domain->blocked);
    }
}
