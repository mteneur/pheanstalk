<?php

/**
 * Tests for the \Pheanstalk\Connection.
 * Relies on a running beanstalkd server.
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class Pheanstalk_ConnectionTest
	extends UnitTestCase
{
	const SERVER_HOST = 'localhost';
	const SERVER_PORT = '11300';

	public function testConnectionFailsToIncorrectPort()
	{
		$connection = new \Pheanstalk\Connection(
			self::SERVER_HOST,
			self::SERVER_PORT + 1
		);

		$command = new \Pheanstalk\Command\UseCommand('test');
		$this->expectException('Pheanstalk_Exception_ConnectionException');
		$connection->dispatchCommand($command);
	}

	public function testDispatchCommandSuccessful()
	{
		$connection = new \Pheanstalk\Connection(
			self::SERVER_HOST,
			self::SERVER_PORT
		);

		$command = new Pheanstalk_Command_UseCommand('test');
		$response = $connection->dispatchCommand($command);

		$this->assertIsA($response, 'Pheanstalk_Response');
	}

	// ----------------------------------------
	// private

	private function _getConnection()
	{
		return new \Pheanstalk\Connection(self::SERVER_HOST, self::SERVER_PORT);
	}
}

