<?php
namespace Pheanstalk\Command;
use Pheanstalk\YamlResponseParser;

/**
 * The 'stats' command.
 * Statistical information about the system as a whole.
 *
 * @author Paul Annesley
 * @package Pheanstalk
 * @licence http://www.opensource.org/licenses/mit-license.php
 */
class StatsCommand
	extends AbstractCommand
{
	/* (non-phpdoc)
	 * @see Pheanstalk_Command::getCommandLine()
	 */
	public function getCommandLine()
	{
		return 'stats';
	}

	/* (non-phpdoc)
	 * @see Pheanstalk_Command::getResponseParser()
	 */
	public function getResponseParser()
	{
		return new \Pheanstalk_YamlResponseParser(
			Pheanstalk_YamlResponseParser::MODE_DICT
		);
	}
}
