<?php


namespace App\Command;

use App\Repository\CommentRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:delete-pokemon',
    description: 'Add a short description for your command',
)]
class DeleteCommand extends Command
{

    public function __construct( private CommentRepository $commentRepository)
    {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output ): int
    {

        $this->commentRepository->deletePokemon();

        $output->writeln("Deleted with Success");


        return Command::SUCCESS;
    }
}
