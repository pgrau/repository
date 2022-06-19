<?php

declare(strict_types=1);

namespace Repository\Infrastructure\UI\Console;

use Repository\UseCase\GetProjectByPackageName\Request;
use Repository\UseCase\GetProjectByPackageName\UseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetProjectsByPackageNameCommand extends Command
{
    const FOLDER = __DIR__ . '/../../../../projects';

    protected static $defaultName = 'project:filter:package:name';

    public function __construct(
        private UseCase $useCase
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Get Projects filtered by directory and package name')
            ->addArgument('packageName', InputArgument::REQUIRED, 'Name of the package')
            ->addArgument('folder', InputArgument::OPTIONAL, 'path of the projects', self::FOLDER)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $packageName = \strval($input->getArgument('packageName'));
        $folder = \strval($input->getArgument('folder'));
        $request = new Request($folder, $packageName);

        $collection = $this->useCase->execute($request)->get();
        $rows = [];
        foreach ($collection as $item) {
            $rows[] = [$item->name()];
        }

        $table = new Table($output);
        $table
            ->setHeaders(['Project'])
            ->setRows($rows)
        ;
        $table->render();

        return Command::SUCCESS;
    }
}
