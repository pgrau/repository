<?php

declare(strict_types=1);

namespace Repository\Domain\Code;

use Repository\Domain\Shared\Url;
use SplObserver;

final class Package implements \SplSubject
{
    private \SplObjectStorage $observers;

    public function __construct(
        private readonly string $name,
        private readonly string $version,
        private readonly Url $url,
        private readonly string $reference,
    ) {
        $this->observers = new \SplObjectStorage();
    }

    public function pushCommit(Commit $commit): void
    {
        if ($this->url()->get() === $commit->url()) {
            $this->notify();
        }
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        /** @var SplObserver $observer */
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function name(): string
    {
        return $this->name;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function url(): Url
    {
        return $this->url;
    }

    public function reference(): string
    {
        return $this->reference;
    }
}
