<?php

include_once("./Services/Repository/classes/class.ilObjectPluginGUI.php");
require_once(__DIR__."/../vendor/autoload.php");


/**
 * User Interface class for career goal repository object.
 *
 * @ilCtrl_isCalledBy ilObjTalentAssessmentGUI: ilRepositoryGUI, ilAdministrationGUI, ilObjPluginDispatchGUI
 * @ilCtrl_Calls ilObjTalentAssessmentGUI: ilPermissionGUI, ilInfoScreenGUI, ilObjectCopyGUI, ilCommonActionDispatcherGUI
 * @ilCtrl_Calls ilObjTalentAssessmentGUI: ilTalentAssessmentSettingsGUI, ilTalentAssessmentObserverGUI, ilRepositorySearchGUI
 * @ilCtrl_Calls ilObjTalentAssessmentGUI: ilTalentAssessmentObservationsGUI
 *
 * @author 		Stefan Hecken <stefan.hecken@concepts-and-training.de>
 */
class ilObjTalentAssessmentGUI extends ilObjectPluginGUI
{
	const CMD_AUTOCOMPLETE = "userfieldAutocomplete";
	const TAB_SETTINGS = "tab_settings";

	/**
	 * Initialisation
	 */
	protected function afterConstructor()
	{
		global $DIC;

		$this->g_access = $DIC->access();
		$this->g_tabs = $DIC->tabs();
		$this->g_ctrl = $DIC->ctrl();

		$this->tpl->addJavaScript('./Services/Form/js/date_duration.js');
	}

	/**
	 * Get type.
	 */
	final public function getType()
	{
		return "xtas";
	}

	/**
	 * After object has been created -> jump to this command
	 */
	public function getAfterCreationCmd()
	{
	}

	/**
	 * Get standard command
	 */
	public function getStandardCmd()
	{
	}

	public function initCreateForm($a_new_type)
	{
		$form = parent::initCreateForm($a_new_type);

		$form->clearCommandButtons();
		$form->addCommandButton("cancel", "Zurück");
		$autocomplete_link = $this->g_ctrl->getLinkTarget($this, self::CMD_AUTOCOMPLETE, "", true);
		$org_unit_options = $this->getOrgUnitOptions();
		$this->addSettingsFormItems($form, $org_unit_options, $autocomplete_link);

		return $form;
	}

	public function addSettingsFormItems(\ilPropertyFormGUI $form, array $org_unit_options, $autocomplete_link)
	{
		$ti = new \ilTextInputGUI($this->txt("username"), "username");
		$ti->setRequired(true);
		$ti->setInfo($this->txt("username_info"));
		$ti->setDataSource($autocomplete_link);
		$form->addItem($ti);

		require_once('Services/Form/classes/class.ilDateDurationInputGUI.php');
		$du = new \ilDateDurationInputGUI($this->txt("date"), "date");
		$du->setShowTime(true);
		$du->setStartText($this->txt("start"));
		$du->setEndText($this->txt("end"));
		$form->addItem($du);

		$si = new \ilTextInputGUI($this->txt("venue"), "venue");
		$form->addItem($si);

		$si = new \ilSelectInputGUI($this->txt("org_unit"), "org_unit");
		$options = array(null=>$this->txt("pls_select")) + $org_unit_options;
		$si->setOptions($options);
		$si->setInfo($this->txt("org_unit_info"));
		$form->addItem($si);
	}

	protected function renderUserSearch()
	{
		include_once "./Services/Search/classes/class.ilRepositorySearchGUI.php";
			ilRepositorySearchGUI::fillAutoCompleteToolbar(
				$this,
				$this->gToolbar,
				array(
					"auto_complete_name"	=> $this->txt("user"),
					"user_type"				=> $types,
					"submit_name"			=> $this->txt("add"),
					"add_search"			=> false
				)
			);
	}

	public function userfieldAutocomplete()
	{
		include_once './Services/User/classes/class.ilUserAutoComplete.php';
		$auto = new ilUserAutoComplete();
		$auto->setSearchFields(array('login','firstname','lastname','email'));
		$auto->enableFieldSearchableCheck(false);
		if (($_REQUEST['fetchall'])) {
			$auto->setLimit(ilUserAutoComplete::MAX_ENTRIES);
		}
		echo $auto->getList($_REQUEST['term']);
		exit();
	}

	protected function getOrgUnitOptions()
	{
		$ret = array();

		$orgus = ilObject2::_getObjectsDataForType("orgu");
		$org_root_id = ilObjOrgUnit::getRootOrgId();
		$orgus = array_filter($orgus, function ($o) use ($org_root_id) {
			if ($o["id"] == $org_root_id) {
				return false;
			}

			return true;
		});

		foreach ($orgus as $key => $orgu) {
			$ret[$orgu["id"]] = $orgu["title"];
		}

		return $ret;
	}
}
