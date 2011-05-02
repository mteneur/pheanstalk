<?php

/**
 * Tests the Pheanstalk exceptions, mainly for parse errors etc.
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class \Pheanstalk\ExceptionsTest
	extends UnitTestCase
{
	public function testPheanstalkException()
	{
		$e = new \Pheanstalk\Exception();
		$this->assertIsA($e, 'Exception');
	}

	public function testClientException()
	{
		$e = new \Pheanstalk\Exception_ClientException();
		$this->assertIsA($e, '\Pheanstalk\Exception');
	}

	public function testConnectionException()
	{
		$e = new \Pheanstalk\Exception_ConnectionException(10, 'test');
		$this->assertIsA($e, '\Pheanstalk\Exception_ClientException');
	}

	public function testCommandException()
	{
		$e = new \Pheanstalk\Exception_CommandException('test');
		$this->assertIsA($e, '\Pheanstalk\Exception_ClientException');
	}

	public function testServerException()
	{
		$e = new \Pheanstalk\Exception_ServerException();
		$this->assertIsA($e, '\Pheanstalk\Exception');
	}

	public function testServerBadFormatException()
	{
		$e = new \Pheanstalk\Exception_ServerBadFormatException();
		$this->assertIsA($e, '\Pheanstalk\Exception_ServerException');
	}

	public function testServerDrainingException()
	{
		$e = new \Pheanstalk\Exception_ServerDrainingException();
		$this->assertIsA($e, '\Pheanstalk\Exception_ServerException');
	}

	public function testServerInternalErrorException()
	{
		$e = new \Pheanstalk\Exception_ServerInternalErrorException();
		$this->assertIsA($e, '\Pheanstalk\Exception_ServerException');
	}

	public function testServerOutOfMemoryException()
	{
		$e = new \Pheanstalk\Exception_ServerOutOfMemoryException();
		$this->assertIsA($e, '\Pheanstalk\Exception_ServerException');
	}

	public function testServerUnknownCommandException()
	{
		$e = new \Pheanstalk\Exception_ServerUnknownCommandException();
		$this->assertIsA($e, '\Pheanstalk\Exception_ServerException');
	}
}
