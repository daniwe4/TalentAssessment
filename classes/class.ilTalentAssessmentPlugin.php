<?php

use CaT\Plugins\TalentAssessment;

include_once("./Services/Repository/classes/class.ilRepositoryObjectPlugin.php");
require_once(__DIR__."/../vendor/autoload.php");

/**
 * career goal plugin for repository
 *
 * @author 		Stefan Hecken <stefan.hecken@concepts-and-training.de>
 */
class ilTalentAssessmentPlugin extends ilRepositoryObjectPlugin
{
	public function getPluginName()
	{
		return "TalentAssessment";
	}

	public function uninstallCustom()
	{
	}

	/**
	 * Get a closure to get txts from plugin.
	 *
	 * @return \Closure
	 */
	public function txtClosure()
	{
		return function ($code) {
			return $this->txt($code);
		};
	}
}
