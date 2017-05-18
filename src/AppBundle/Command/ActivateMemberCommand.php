<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @author Antoine Hérault <antoine.herault@gmail.com>
 */
class ActivateMemberCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('app:member:activate')
            ->setDescription('Activate a member')
            ->setDefinition(array(
                new InputArgument('email', InputArgument::REQUIRED, 'The member\'s email address'),
            ))
            ->setHelp(<<<'EOT'
The <info>app:member:activate</info> command activates a member (will be able to sign in)

  <info>php bin/console bborko@bogus.infoinfo>
EOT
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $email = $input->getArgument('email');

        $manipulator = $this->getContainer()->get('app.services.member_manipulator');
        $manipulator->activateMember($email);

        $output->writeln(sprintf('Member "%s" has been activated.', $email));
    }

    /**
     * {@inheritdoc}
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('email')) {
            $question = new Question('Please enter member\s email:');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception('Email can not be empty');
                }

                return $email;
            });
            $answer = $this->getHelper('question')->ask($input, $output, $question);

            $input->setArgument('email', $answer);
        }
    }
}
