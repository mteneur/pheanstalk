<?php
namespace Pheanstalk;
use Pheanstalk\Response;

/**
 * A connection to a beanstalkd server
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class Connection
{
	const CRLF = "\r\n";
	const CRLF_LENGTH = 2;
	const DEFAULT_CONNECT_TIMEOUT = 2;

	// responses which are global errors, mapped to their exception short-names
	private $_errorResponses = array(
		Response::RESPONSE_OUT_OF_MEMORY => 'OutOfMemory',
		Response::RESPONSE_INTERNAL_ERROR => 'InternalError',
		Response::RESPONSE_DRAINING => 'Draining',
		Response::RESPONSE_BAD_FORMAT => 'BadFormat',
		Response::RESPONSE_UNKNOWN_COMMAND => 'UnknownCommand',
	);

	// responses which are followed by data
	private $_dataResponses = array(
		Response::RESPONSE_RESERVED,
		Response::RESPONSE_FOUND,
		Response::RESPONSE_OK,
	);

	private $_socket;
	private $_hostname;
	private $_port;
	private $_connectTimeout;

	/**
	 * @param string $hostname
	 * @param int $port
	 * @param float $connectTimeout
	 */
	public function __construct($hostname, $port, $connectTimeout = null)
	{
		if (is_null($connectTimeout))
			$connectTimeout = self::DEFAULT_CONNECT_TIMEOUT;

		$this->_hostname = $hostname;
		$this->_port = $port;
		$this->_connectTimeout = $connectTimeout;
	}

	/**
	 * Sets a manually created socket, used for unit testing.
	 * @param Pheanstalk_Socket $socket
	 * @chainable
	 */
	public function setSocket(Socket $socket)
	{
		$this->_socket = $socket;
		return $this;
	}

	/**
	 * @param object $command Pheanstalk_Command
	 * @return object \Pheanstalk\Response
	 * @throws Pheanstalk_Exception_ClientException
	 */
	public function dispatchCommand($command)
	{
		$socket = $this->_getSocket();

		$to_send = $command->getCommandLine().self::CRLF;

		if ($command->hasData())
		{
			$to_send .= $command->getData().self::CRLF;
		}

		$socket->write($to_send);

		$responseLine = $socket->getLine();
		$responseName = preg_replace('#^(\S+).*$#s', '$1', $responseLine);

		if (isset($this->_errorResponses[$responseName]))
		{
			$exception = sprintf(
				'\Pheanstalk\Exception\Server%sException',
				$this->_errorResponses[$responseName]
			);

			throw new $exception(sprintf(
				"%s in response to '%s'",
				$responseName,
				$command
			));
		}

		if (in_array($responseName, $this->_dataResponses))
		{
			$dataLength = preg_replace('#^.*\b(\d+)$#', '$1', $responseLine);
			$data = $socket->read($dataLength);

			$crlf = $socket->read(self::CRLF_LENGTH);
			if ($crlf !== self::CRLF)
			{
				throw new \Pheanstalk\Exception\ClientException(sprintf(
					'Expected %d bytes of CRLF after %d bytes of data',
					self::CRLF_LENGTH,
					$dataLength
				));
			}
		}
		else
		{
			$data = null;
		}

		return $command
			->getResponseParser()
			->parseResponse($responseLine, $data);
	}

	// ----------------------------------------

	/**
	 * Socket handle for the connection to beanstalkd
	 * @return Pheanstalk_Socket
	 * @throws Pheanstalk_Exception_ConnectionException
	 */
	private function _getSocket()
	{
		if (!isset($this->_socket))
		{
			$this->_socket = new Socket\NativeSocket(
				$this->_hostname,
				$this->_port,
				$this->_connectTimeout
			);
		}

		return $this->_socket;
	}
}
