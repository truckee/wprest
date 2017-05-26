<?php
//src\tests\AppBundle\Controller\CreateUserCommandTest.php

namespace tests\AppBundle\Controller;

use AppBundle\Command\CreateUserCommand;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * ActivateMemberCommandTest
 *
 */
class CreateUserCommandTest extends WebTestCase
{

    public function setup() {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\UsersMembers'
        ));
    }

    public function testExecute()
    {
        self::bootKernel();
        $application = new Application(self::$kernel);

        $application->add(new CreateUserCommand());

        $command = $application->find('app:user:create');
        $commandTester = new CommandTester($command);
        $commandTester->execute(array(
            'command'  => $command->getName(),

            // pass arguments to the helper
            'email' => 'developer@bogus.info',
            'password' => 'YumYum',
            'username' => 'developer',

            // prefix the key with two dashes when passing options,
            // e.g: '--some-option' => 'option_value',
        ));

        // the output of the command in the console
        $output = $commandTester->getDisplay();
        $this->assertContains('Created user developer', $output);

        // ...
    }
    
}
