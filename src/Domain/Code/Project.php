<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

use Repository\Domain\Delivery\Pipeline;
use SplSubject;

final class Project implements \SplObserver
{
    /** @var SplSubject[] */
    private array $changedPackages = [];

    public function __construct(
        private readonly string $name
    ) {
    }

    public function name(): string
    {
        return $this->name;
    }

    public function update(\SplSubject $subject): void
    {
        $this->changedPackages[] = clone $subject;
        $this->executePipeline();
    }

    public function executePipeline(): void
    {
        Pipeline::execute($this);
    }

    /**
     * @return SplSubject[]
     */
    public function changedPackages(): array
    {
        return $this->changedPackages;
    }
}
