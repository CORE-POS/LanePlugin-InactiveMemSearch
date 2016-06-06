<?php

use COREPOS\pos\lib\FormLib;

class Test extends PHPUnit_Framework_TestCase
{
    public function testPlugin()
    {
        $obj = new InactiveMemLookup();
        $obj->plugin_transaction_reset();
    }

    public function testSearch()
    {
        $s = new InactiveMemSearch();
        $res = array('CardNo'=>1, 'personNum'=>1, 'LastName'=>'Foo', 'FirstName'=>'Bar');
        $expect = array('results'=> array('1::1'=>'1(CSC) Foo, Bar'));
        SQLManager::addResult($res);
        $this->assertEquals($expect, $s->lookup_by_number(1));
        SQLManager::clear();
        SQLManager::addResult($res);
        $this->assertEquals($expect, $s->lookup_by_text(1));
    }

    public function testTotalAction()
    {
        $ta = new InactiveMemTotalAction();
        $this->assertEquals(true, $ta->apply());

        InactiveMemTotalAction::adminLoginInit();
        $this->assertEquals(true, InactiveMemTotalAction::adminLoginCallback(true));
        $this->assertEquals(false, InactiveMemTotalAction::adminLoginCallback(false));
    }     
}

