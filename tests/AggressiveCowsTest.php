<?php

namespace App\Tests;

use App\AggressiveCows;
use Exception;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class AggressiveCowsTest extends TestCase
{

    #[Test]
    public function it_cannot_be_more_than_100000_stalls()
    {
        $aggressiveCow = new AggressiveCows(
            cowNumber: 5,
        );

        $error = null;
        try {
            $aggressiveCow->calculateMinimumDistance(range(1, 100_001));
        } catch (Exception $e) {
            $error =  $e->getMessage();
        }


        $this->assertNotNull($error);
        $this->assertEquals('It cannot be more than 100000 stall locations.', $error);
    }

    #[Test]
    public function there_must_be_at_least_2_cows()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 1,
        );

        $error = null;
        try {
            $aggressiveCows->calculateMinimumDistance([1, 2, 8, 4, 9]);
        } catch (Exception $e) {
            $error =  $e->getMessage();
        }

        $this->assertNotNull($error);
        $this->assertEquals('Cow number must be at least 2 cows.', $error);
    }

    #[Test]
    public function when_there_is_2_cow_the_distance_is_difference_of_first_position_and_last()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 2,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance([1, 2, 8, 4, 9]);

        $this->assertEquals(8, $minimumDistance);
    }

    /**
     * @throws Exception
     */
    #[Test]
    public function it_returns_1_when_there_is_no_place_between()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 3,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance(range(1, 3));

        $this->assertEquals(1, $minimumDistance);
    }

    #[Test]
    public function it_finds_minimum_distance_3_for_3_cows()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 3,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance([1, 2, 8, 4, 9]);

        $this->assertEquals(3, $minimumDistance);
    }

    #[Test]
    public function it_finds_minimum_distance_4_for_3_cows()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 3,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance([1, 5, 10]);

        $this->assertEquals(4, $minimumDistance);
    }

    #[Test]
    public function it_finds_minimum_distance_3_for_4_cows()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 4,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance([1, 2, 8, 4, 9]);

        $this->assertEquals(1, $minimumDistance);
    }

    #[Test]
    public function it_finds_minimum_distance_3_for_5_cows()
    {
        $aggressiveCows = new AggressiveCows(
            cowNumber: 5,
        );

        $minimumDistance = $aggressiveCows->calculateMinimumDistance([1, 2, 8, 4, 9]);

        $this->assertEquals(1, $minimumDistance);
    }


}
