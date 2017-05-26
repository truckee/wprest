<?php
//src\tests\AppBundle\Controller\CreateMemberCommandTest.php

namespace tests\AppBundle\Controller;

use AppBundle\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * ActivateMemberCommandTest
 *
 */
class CreateMemberCommandTest extends WebTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new CreateUserCommand());

        $command = $application->find('app:member:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'email' => 'developer@bogus.info',
            'password' => 'YumYum',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Created member developer@bogus.info', $output);

        // ...
    }
    
}
