<?php
/**
 * This file is part of the prooph/snapshot-store.
 * (c) 2017-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2017-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Prooph\SnapshotStore;

final class InMemorySnapshotStore implements SnapshotStore
{
    /**
     * @var array
     */
    private $map = [];

    public function get($aggregateType, $aggregateId)
    {
        if (! isset($this->map[$aggregateType][$aggregateId])) {
            return null;
        }

        return $this->map[$aggregateType][$aggregateId];
    }

    public function save(Snapshot ...$snapshots)
    {
        foreach ($snapshots as $snapshot) {
            $this->map[$snapshot->aggregateType()][$snapshot->aggregateId()] = $snapshot;
        }
    }

    public function removeAll($aggregateType)
    {
        unset($this->map[$aggregateType]);
    }
}
