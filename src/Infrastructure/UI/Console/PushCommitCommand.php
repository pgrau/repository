<?php

declare(strict_types=1);

namespace Repository\Infrastructure\UI\Console;

use Repository\Domain\Code\Commit;
use Repository\Domain\Shared\Url;
use Repository\UseCase\ExecuteContinuousIntegrationByCommit\Request;
use Repository\UseCase\ExecuteContinuousIntegrationByCommit\UseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PushCommitCommand extends Command
{
    const FOLDER = __DIR__ . '/../../../../projects';

    protected static $defaultName = 'commit:push';

    public function __construct(
        private UseCase $useCase
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Push a commit and get the projects need to be called by CI/CD')
            ->addArgument('urlGit', InputArgument::REQUIRED, 'path of git')
            ->addArgument('commit', InputArgument::REQUIRED, 'commit id')
            ->addArgument('version', InputArgument::REQUIRED, 'branch or tag')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        \apcu_clear_cache();

        $urlGit = \strval($input->getArgument('urlGit'));
        $commit = \strval($input->getArgument('commit'));
        $version = \strval($input->getArgument('version'));

        $commit = new Commit(
            new Url($urlGit),
            $commit,
            $version,
        );

        $this->useCase->execute(new Request(self::FOLDER, $commit));

        $iterator = new \APCUIterator();
        while ($iterator->valid()) {
            $message = sprintf('<info>Executing pipeline of project %s</info>', $iterator->key());
            $output->writeln($message);

            $iterator->next();
        }

        return Command::SUCCESS;
    }
}
