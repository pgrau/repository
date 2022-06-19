<?php

declare(strict_types=1);

namespace Repository\Infrastructure\UI\Console;

use Repository\UseCase\GetPackagesByDirectory\Request;
use Repository\UseCase\GetPackagesByDirectory\UseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetPackagesByDirectoryCommand extends Command
{
    const FOLDER = __DIR__ . '/../../../../projects';

    protected static $defaultName = 'project:packages';

    public function __construct(
        private UseCase $useCase
    ) {
        parent::__construct(self::$defaultName);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Get Packages by directory')
            ->addArgument('folder', InputArgument::OPTIONAL, 'path of the projects', self::FOLDER)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $folder = \strval($input->getArgument('folder'));
        $request = new Request($folder);

        $collection = $this->useCase->execute($request)->get();
        foreach ($collection as $item) {
            $project = $item->project;
            $packages = $item->packages;

            $message = sprintf('<info>Project %s</info>', $project->name());
            $output->writeln($message);

            $rows = [];
            foreach ($packages->get() as $package) {
                $rows[] = [
                  $package->name(),
                  $package->version(),
                  $package->reference(),
                  $package->url()->get(),
                ];
            }

            $table = new Table($output);
            $table
                ->setHeaders(['Name', 'Version', 'Reference', 'Url'])
                ->setRows($rows)
            ;
            $table->render();
        }

        return Command::SUCCESS;
    }
}
