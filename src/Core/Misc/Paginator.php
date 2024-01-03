<?php

namespace Kubinyete\Edi\PagSeguro\Core\Misc;

use Closure;
use Traversable;
use IteratorAggregate;

/**
 * An anonymous paginator object for interactive pagination using an iterator interface
 * Requires a custom fetcher function to fetch the next page of items
 *
 * @template T
 */
class Paginator implements IteratorAggregate
{
    /**
     * Creates a new paginator
     *
     * @param Closure<iterable<T>> $fetcher
     * @param integer $page
     * @param integer $perPage
     * @param integer $totalPages
     * @param iterable|null $items
     */
    public function __construct(
        private Closure $fetcher,
        private int $page = 1,
        private int $perPage = 100,
        private int $totalPages = 0,
        private ?iterable $items = null
    ) {
        $this->page = max(1, $page);
        $this->perPage = max(1, $perPage);
        $this->totalPages = max(0, $totalPages);
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    protected function setTotalPages(int $i): static
    {
        $this->totalPages = max(0, $i);
        return $this;
    }

    //

    public function setPage(int $page): static
    {
        $previousPage = $this->page;
        $nextPage = max(1, $page);

        if ($this->totalPages > 0) {
            $nextPage = min($this->totalPages, $nextPage);
        }

        if ($nextPage != $previousPage) {
            $this->unloadPage();
        }

        $this->page = $nextPage;
        return $this;
    }

    public function incrementPage(int $inc = 1): static
    {
        return $this->setPage($this->page + $inc);
    }

    public function decrementPage(int $dec = 1): static
    {
        return $this->setPage($this->page - $dec);
    }

    //

    protected function hasPageLeft(): bool
    {
        return $this->totalPages <= 0 || $this->page < $this->totalPages;
    }

    protected function isPageLoaded(): bool
    {
        return !is_null($this->items);
    }

    /**
     * Fetches the current page of items from the fetcher function
     *
     * @return iterable<T>
     */
    protected function loadPage(): iterable
    {
        return $this->items = $this->fetcher->__invoke(
            $this->page,
            $this->perPage,
            fn (int $totalPages) => $this->setTotalPages($totalPages)
        );
    }

    protected function unloadPage(): void
    {
        $this->items = null;
    }

    /**
     * Get the current page of items already loaded or fetches them from the fetcher function
     *
     * @return iterable<T>
     */
    public function getItems(): iterable
    {
        if ($this->isPageLoaded()) {
            return $this->items;
        }

        return $this->loadPage();
    }

    /**
     * Fetches the next page of items from the fetcher function or returns null if there are no more pages left
     *
     * @return iterable<T>|null
     */
    public function nextItems(): ?iterable
    {
        if (!$this->isPageLoaded()) {
            return $this->getItems();
        } else {
            if (!$this->hasPageLeft()) {
                return null;
            }

            $this->incrementPage();
            return $this->getItems();
        }
    }

    /**
     * Gets the iterator for all available pages
     *
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        $this->setPage(1);
        yield from ($items = $this->getItems());

        while ($this->hasPageLeft() && $items) {
            $this->incrementPage();
            yield from ($items = $this->getItems());
        }
    }
}
