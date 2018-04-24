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

interface SnapshotStore
{
    public function get($aggregateType, $aggregateId);

    public function save(Snapshot ...$snapshots);

    public function removeAll($aggregateType);
}
