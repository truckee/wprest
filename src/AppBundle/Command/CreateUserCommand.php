<?php //

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
                ->setName('app:user:create')
                ->setDescription('Create a user.')
                ->setDefinition(array(
                    new InputArgument('username', InputArgument::REQUIRED, 'A username'),
                    new InputArgument('email', InputArgument::REQUIRED, 'An email'),
                    new InputArgument('password', InputArgument::REQUIRED, 'A password'),
                    new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
                    new InputOption('superadmin', null, InputOption::VALUE_NONE, 'Set the user as superadmin'),
                ))
                ->setHelp(<<<EOT
The <info>app:user:create</info> command creates a user:

  <info>php app/console app:user:create</info>

This interactive shell will ask you for: username, email, password.

You can alternatively specify the username, email, password as arguments:

  <info>php app/console app:user:create bborko borko@bogus.info mypassword</info>

EOT
        );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $inactive = $input->getOption('inactive');
        $superadmin = $input->getOption('superadmin');

        $manipulator = $this->getContainer()->get('app.services.user_manipulator');
        $key = sha1($username . time());
        $manipulator->setApikey($key);
        $manipulator->create($username, $password, $email, !$inactive, $superadmin);

        $output->writeln(sprintf('Created user <comment>%s</comment>' . "\n" . 'API key: ' . $key, $username));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $helper = $this->getHelper('question');

        if (!$input->getArgument('username')) {
            $question = new Question('Please enter a username: ');
            $question->setValidator(function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                    'A username is required'
                    );
                }

                return $answer;
            });
            $question->setMaxAttempts(1);

            $input->setArgument('username', $helper->ask($input, $output, $question));
        }

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
            $question = new Question('Please enter a password: ');
            $question->setValidator(function ($answer) {
                if (empty($answer)) {
                    throw new \RuntimeException(
                    'A password is required'
                    );
                }

                return $answer;
            });
            $question->setMaxAttempts(1);

            $input->setArgument('password', $helper->ask($input, $output, $question));
        }

    }
}
