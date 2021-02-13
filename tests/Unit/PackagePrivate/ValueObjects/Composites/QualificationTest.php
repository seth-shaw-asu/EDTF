<?php

namespace EDTF\Tests\Unit\PackagePrivate\ValueObjects\Composites;

use EDTF\PackagePrivate\ValueObjects\Composites\Qualification;
use PHPUnit\Framework\TestCase;

/**
 * @covers \EDTF\PackagePrivate\ValueObjects\Composites\Qualification
 */
class QualificationTest extends TestCase
{
    public function testCreateQualification()
    {
        $yearOpenFlag = '?';
        $monthOpenFlag = null;
        $dayOpenFlag = '~';
        $yearCloseFlag = null;
        $monthCloseFlag = '%';
        $dayCloseFlag = null;

        $qualification = new Qualification(
            $yearOpenFlag,
            $monthOpenFlag,
            $dayOpenFlag,
            $yearCloseFlag,
            $monthCloseFlag,
            $dayCloseFlag
        );

        $this->assertSame('?', $qualification->getYearOpenFlag());
        $this->assertNull($qualification->getMonthOpenFlag());
        $this->assertSame('~', $qualification->getDayOpenFlag());
        $this->assertNull($qualification->getYearCloseFlag());
        $this->assertSame('%', $qualification->getMonthCloseFlag());
        $this->assertNull($qualification->getDayCloseFlag());
    }
}