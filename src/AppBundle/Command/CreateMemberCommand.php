<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Description of CreateMemberCommand
 *
 * @author George
 */
class CreateMemberCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
                ->setName('app:member:create')
                ->setDescription('Add a member.')
                ->setDefinition(array(
                    new InputArgument('email', InputArgument::REQUIRED, 'An email'),
                    new InputArgument('password',InputOption::VALUE_NONE, 'A password'),
                    new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
                ))
                ->setHelp(<<<EOT
The <info>app:member:create</info> command creates an active member:

  <info>php bin/console app:member:create</info>

This interactive shell will ask you for these fields:  email, password. A password is not required.

You can alternatively specify the email, password as arguments:

  <info>php app/console app:member:create borko@bogus.info 123Abc</info>

You can create an inactive user (will not be able to sign in):

  <info>php bin/console app:user:create bborko --inactive</info>

EOT
        );
        
    }
    

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $inactive = $input->getOption('inactive');

        $manipulator = $this->getContainer()->get('app.services.member_manipulator');
        $manipulator->create($email, $password, !$inactive);

        $output->writeln(sprintf('Created member %s', $email));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        if (!$input->getArgument('email')) {
            $question = new Question('Please enter an email: ');
            $question->setValidator(function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                    'An e-mail address is required'
                    );
                }

                return $answer;
            });
            $question->setMaxAttempts(1);

            $input->setArgument('email', $helper->ask($input, $output, $question));
        }

        if (!$input->getArgument('password')) {
            $question = new Question('(Optional) Enter a password: ');
            $question->setValidator(function ($answer) {
//                if (empty($answer)) {
//                    throw new \RuntimeException(
//                    'A password is required'
//                    );
//                }

                return $answer;
            });
            $question->setMaxAttempts(1);

            $input->setArgument('password', $helper->ask($input, $output, $question));
        }

    }
}
