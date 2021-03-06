<?php
/**
 * File containing the ezcWebdavFileBackendOptionsTestCase class.
 * 
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 * 
 *   http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 *
 * @package Webdav
 * @version //autogen//
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @subpackage Test
 */

require_once dirname( __FILE__ ) . '/property_test.php';

/**
 * Test case for the ezcWebdavFileBackendOptions class.
 * 
 * @package Webdav
 * @version //autogen//
 * @subpackage Test
 */
class ezcWebdavLockIfHeaderNoTagListTest extends ezcTestCase
{
    public static function suite()
    {
		return new PHPUnit_Framework_TestSuite( __CLASS__ );
    }

    public function testConstructor()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        $this->assertAttributeEquals(
            $item,
            'items',
            $list
        );
    }

    public function testOffsetSetFailure()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            $list['/some/path'] = 23;
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'items',
            $list
        );
    }

    public function testOffsetGetSuccess()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );
        
        $this->assertEquals(
            $item,
            $list['/some/path']
        );
        $this->assertEquals(
            $item,
            $list['/']
        );
    }

    public function testOffsetGetFailure()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            $list[''];
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            $list[23];
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetIssetSuccess()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        $this->assertTrue(
            isset( $list['/'] )
        );
        $this->assertTrue(
            isset( $list['/some/path'] )
        );
        $this->assertTrue(
            isset( $list['/none/existent'] )
        );
    }

    public function testOffsetIssetFailure()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            isset( $list[''] );
            $this->fail( 'Exception not thrown on invalid offset.' );
        }
        catch ( ezcBaseValueException $e ) {}

        try
        {
            isset( $list[23] );
            $this->fail( 'Exception not thrown on invalid value.' );
        }
        catch ( ezcBaseValueException $e ) {}
    }

    public function testOffsetUnsetFailure()
    {
        $item = array( new ezcWebdavLockIfHeaderListItem() );
        $list = new ezcWebdavLockIfHeaderNoTagList( $item );

        try
        {
            unset( $list['/some/path'] );
            $this->fail( 'Exception not thrown on set access.' );
        }
        catch ( RuntimeException $e ) {}

        $this->assertAttributeSame(
            $item,
            'items',
            $list
        );
    }

    public function testGetLockTokens()
    {
        $item1 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-1' ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-2', true ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-3' ),
            ),
            array(
                new ezcWebdavLockIfHeaderCondition( 'etag-1', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-2', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-3' ),
            )
        );
        $item2 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-1' ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-4' ),
            ),
            array(
                new ezcWebdavLockIfHeaderCondition( 'etag-1' ),
                new ezcWebdavLockIfHeaderCondition( 'etag-4', true ),
                new ezcWebdavLockIfHeaderCondition( 'etag-5' ),
            )
        );
        $item3 = new ezcWebdavLockIfHeaderListItem(
            array(
                new ezcWebdavLockIfHeaderCondition( 'lock-token-5', true ),
                new ezcWebdavLockIfHeaderCondition( 'lock-token-6', true ),
            ),
            array()
        );

        $list = new ezcWebdavLockIfHeaderNoTagList(
            array( $item1, $item2, $item3 )
        );

        $this->assertEquals(
            array(
                0 => 'lock-token-1',
                1 => 'lock-token-2',
                2 => 'lock-token-3',
                4 => 'lock-token-4',
                5 => 'lock-token-5',
                6 => 'lock-token-6',
            ),
            $list->getLockTokens()
        );
    }
}

?>
