<?php

namespace AppBundle\Command;

use League\Csv\Reader;
use AppBundle\Entity\Examen;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class CsvImportCommand
 * @package AppBundle\ConsoleCommand
 */
class CsvImportCommand extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CsvImportCommand constructor.
     *
     * @param EntityManagerInterface $em
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
    }

    /**
     * Configure
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('csv:import')
            ->setDescription('Imports the mock CSV data file')
        ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        

 $io = new SymfonyStyle($input, $output);
 $io->title('Attempting import of Feed...');

 $reader = Reader::createFromPath('%kernel.root_dir%/../src/AppBundle/Data/users - Feuil1.csv');

 // https://github.com/thephpleague/csv/issues/208
 $results = $reader->fetchAssoc();

 $io->progressStart(iterator_count($results));

 foreach ($results as $row) {
    
     // create new athlete
     $user = (new User())
         ->setUsername($row['username'])
         ->setReference($row['reference'])
         ->setNomLabo($row['nom_labo'])
         ->setPlainPassword($row['password'])
         ->setEmail($row['username'].'457@gmail.com')
         ->setEnabled(1)
     ;

     $this->em->persist($user);
 }

    $this->em->flush();

    $io->progressFinish();
    $io->success('Command exited cleanly!');
    }
}