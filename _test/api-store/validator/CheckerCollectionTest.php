<?php
namespace asbamboo\api\_test\apiStore\validator;

use PHPUnit\Framework\TestCase;
use asbamboo\api\apiStore\validator\CheckerCollection;
use asbamboo\http\ServerRequest;
use asbamboo\api\apiStore\validator\SignCheckerByFixedSecurity;
use asbamboo\api\apiStore\validator\TimestampChecker;

class CheckerCollectionTest extends TestCase
{
    public function testAdd()
    {
        $CheckerCollection      = new CheckerCollection();
        $Request                = new ServerRequest();
        $SignChecker            = new SignCheckerByFixedSecurity($Request);
        $TimestampChecker       = new TimestampChecker($Request);

        $CheckerCollection->add($SignChecker);
        $count  = 0;
        foreach($CheckerCollection AS $Checker){
            $count++;
        }
        $this->assertEquals(1, $count);

        $CheckerCollection->add($TimestampChecker);
        $count  = 0;
        foreach($CheckerCollection AS $Checker){
            $count++;
        }
        $this->assertEquals(2, $count);
        return [$CheckerCollection, $SignChecker, $TimestampChecker];
    }

    /**
     * @depends testAdd
     */
    public function testRemove($data)
    {
        list($CheckerCollection, $SignChecker, $TimestampChecker) = $data;

        $CheckerCollection->remove($SignChecker);
        $count  = 0;
        foreach($CheckerCollection AS $Checker){
            $count++;
        }
        $this->assertEquals(1, $count);

        $CheckerCollection->remove($TimestampChecker);
        $count  = 0;
        foreach($CheckerCollection AS $Checker){
            $count++;
        }
        $this->assertEquals(0, $count);
    }
}