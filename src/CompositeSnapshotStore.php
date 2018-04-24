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

final class CompositeSnapshotStore implements SnapshotStore
{
    /**
     * @var SnapshotStore[]
     */
    private $snapshotStores;

    public function __construct(SnapshotStore ...$snapshotStores)
    {
        $this->snapshotStores = $snapshotStores;
    }

    public function get($aggregateType, $aggregateId)
    {
        foreach ($this->snapshotStores as $snapshotStore) {
            $snapshot = $snapshotStore->get($aggregateType, $aggregateId);

            if (null !== $snapshot) {
                return $snapshot;
            }
        }

        return null;
    }

    public function save(Snapshot ...$snapshots)
    {
        foreach ($this->snapshotStores as $snapshotStore) {
            $snapshotStore->save(...$snapshots);
        }
    }

    public function removeAll($aggregateType)
    {
        foreach ($this->snapshotStores as $snapshotStore) {
            $snapshotStore->removeAll($aggregateType);
        }
    }
}
