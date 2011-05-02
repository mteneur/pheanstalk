<?php

/**
 * Tests the Pheanstalk exceptions, mainly for parse errors etc.
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class Pheanstalk_ExceptionsTest
	extends UnitTestCase
{
	public function testPheanstalkException()
	{
		$e = new \Pheanstalk\Exception();
		$this->assertIsA($e, 'Exception');
	}

	public function testClientException()
	{
		$e = new \Pheanstalk\Exception\ClientException();
		$this->assertIsA($e, '\Pheanstalk\Exception');
	}

	public function testConnectionException()
	{
		$e = new \Pheanstalk\Exception\ConnectionException(10, 'test');
		$this->assertIsA($e, '\Pheanstalk\Exception\ClientException');
	}

	public function testCommandException()
	{
		$e = new \Pheanstalk\Exception\CommandException('test');
		$this->assertIsA($e, '\Pheanstalk\Exception\ClientException');
	}

	public function testServerException()
	{
		$e = new \Pheanstalk\Exception\ServerException();
		$this->assertIsA($e, '\Pheanstalk\Exception');
	}

	public function testServerBadFormatException()
	{
		$e = new \Pheanstalk\Exception\ServerBadFormatException();
		$this->assertIsA($e, '\Pheanstalk\Exception\ServerException');
	}

	public function testServerDrainingException()
	{
		$e = new \Pheanstalk\Exception\ServerDrainingException();
		$this->assertIsA($e, '\Pheanstalk\Exception\ServerException');
	}

	public function testServerInternalErrorException()
	{
		$e = new \Pheanstalk\Exception\ServerInternalErrorException();
		$this->assertIsA($e, '\Pheanstalk\Exception\ServerException');
	}

	public function testServerOutOfMemoryException()
	{
		$e = new \Pheanstalk\Exception\ServerOutOfMemoryException();
		$this->assertIsA($e, '\Pheanstalk\Exception\ServerException');
	}

	public function testServerUnknownCommandException()
	{
		$e = new \Pheanstalk\Exception\ServerUnknownCommandException();
		$this->assertIsA($e, '\Pheanstalk\Exception\ServerException');
	}
}
