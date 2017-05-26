<?php
//src\tests\AppBundle\Controller\ActivateMemberCommandTest.php

namespace tests\AppBundle\Controller;

use AppBundle\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * ActivateMemberCommandTest
 *
 */
class ActivateMemberCommandTest extends WebTestCase
{
    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new CreateUserCommand());

        $command = $application->find('app:member:activate');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'email' => 'developer@bogus.info',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Member "developer@bogus.info" has been activated', $output);

        // ...
    }
    
}
