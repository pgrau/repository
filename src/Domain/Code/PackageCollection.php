<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

final class PackageCollection
{
    /** @var Package[] */
    private array $collection = [];

    public function add(Package $package): self
    {
        $this->collection[] = $package;

        return $this;
    }

    /**
     * @return Package[]
     */
    public function get(): array
    {
        return $this->collection;
    }

    public function existByName(string $name): bool
    {
        foreach ($this->collection as $package) {
            if ($package->name() === $name) {
                return true;
            }
        }

        return false;
    }

    public function count(): int
    {
        return count($this->get());
    }
}
