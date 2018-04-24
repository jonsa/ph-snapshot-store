<?php
/**
 * This file is part of the prooph/snapshot-store.
 * (c) 2017-2017 prooph software GmbH <contact@prooph.de>
 * (c) 2017-2017 Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace ProophTest\SnapshotStore;

use PHPUnit\Framework\TestCase;
use Prooph\SnapshotStore\Snapshot;

class SnapshotTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_and_returns_values()
    {
        $now = new \DateTimeImmutable();

        $snapshot = new Snapshot(
            'foo',
            'some_id',
            [
                'some' => 'thing',
            ],
            1,
            $now
        );

        $this->assertEquals('foo', $snapshot->aggregateType());
        $this->assertEquals('some_id', $snapshot->aggregateId());
        $this->assertEquals(['some' => 'thing'], $snapshot->aggregateRoot());
        $this->assertEquals(1, $snapshot->lastVersion());
        $this->assertSame($now, $snapshot->createdAt());
    }

    /**
     * @test
     */
    public function it_requires_min_length_for_aggregate_type()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Snapshot(
            '',
            'some_id',
            [
                'some' => 'thing',
            ],
            1,
            new \DateTimeImmutable()
        );
    }

    /**
     * @test
     */
    public function it_requires_min_length_for_aggregate_id()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Snapshot(
            'foo',
            '',
            [
                'some' => 'thing',
            ],
            1,
            new \DateTimeImmutable()
        );
    }

    /**
     * @test
     */
    public function it_requires_min_for_last_version()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Snapshot(
            'foo',
            'some_id',
            [
                'some' => 'thing',
            ],
            0,
            new \DateTimeImmutable()
        );
    }
}
