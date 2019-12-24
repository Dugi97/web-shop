<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateUserCommand extends Command
{
    protected static $defaultName = 'app:create-user';

    private $encoder;
    private $em;

    public function __construct(?string $name = null, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    {
        $this->encoder = $encoder;
        $this->em = $em;
        parent::__construct($name);
    }

    protected function configure()
    {
       $user = new User();

       $user->setEmail('admin@admin.com');
       $user->setUsername('admin');
       $user->setRole(['ROLE_SUPER_ADMIN']);
       $user->setPassword($this->encoder->encodePassword($user, 'admin'));
       $this->em->persist($user);
       $this->em->flush();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('You are about to ');
        $output->write('create a user.');
    }
}