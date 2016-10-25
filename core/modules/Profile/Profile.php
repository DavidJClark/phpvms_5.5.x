<?php
/**
 * phpVMS - Virtual Airline Administration Software
 * Copyright (c) 2008 Nabeel Shahzad
 * For more information, visit www.phpvms.net
 *	Forums: http://www.phpvms.net/forum
 *	Documentation: http://www.phpvms.net/docs
 *
 * phpVMS is licenced under the following license:
 *   Creative Commons Attribution Non-commercial Share Alike (by-nc-sa)
 *   View license.txt in the root, or visit http://creativecommons.org/licenses/by-nc-sa/3.0/
 *
 * @author Nabeel Shahzad
 * @copyright Copyright (c) 2008, Nabeel Shahzad
 * @link http://www.phpvms.net
 * @license http://creativecommons.org/licenses/by-nc-sa/3.0/
 */

class Profile extends CodonModule
{

	/**
	 * Profile::index()
	 *
	 * @return
	 */
	public function index()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

		/*
		 * This is from /profile/editprofile
		 */
		 if(isset($this->post->action)) {
			if($this->post->action == 'saveprofile') {
				$this->save_profile_post();
			}

			/* this comes from /profile/changepassword
			*/
			if($this->post->action == 'changepassword') {
				$this->change_password_post();
			}
		}

        $pilot = PilotData::getPilotData(Auth::$pilot->pilotid);

		if(Config::Get('TRANSFER_HOURS_IN_RANKS') == true) {
			$totalhours = $pilot->totalhours + $pilot->transferhours;
		} else {
			$totalhours = $pilot->totalhours;
		}

		$this->set('pilotcode', PilotData::getPilotCode($pilot->code, $pilot->pilotid));
		$this->set('report', PIREPData::getLastReports($pilot->pilotid));
		$this->set('nextrank', RanksData::getNextRank($totalhours));
		$this->set('allawards', AwardsData::getPilotAwards($pilot->pilotid));
		$this->set('userinfo', $pilot);
        $this->set('pilot', $pilot);
		$this->set('pilot_hours', $totalhours);

		$this->render('profile_main.php');

		CodonEvent::Dispatch('profile_viewed', 'Profile');
	}

	/**
	 * This is the public profile for the pilot
	 */
	/**
	 * Profile::view()
	 *
	 * @param string $pilotid
	 * @return
	 */
	public function view($pilotid='')
	{
            #replacement for OFC charts - Google Charts API - simpilot
            $this->set('chart_url', ChartsData::build_pireptable(PilotData::parsePilotID($pilotid), 30));
            #end

            $pilotid = PilotData::parsePilotID($pilotid);
            $pilot = PilotData::getPilotData($pilotid);

            $this->title = 'Profile of '.$pilot->firstname.' '.$pilot->lastname;

            $this->set('userinfo', $pilot);
            $this->set('pilot', $pilot);

            $this->set('allfields', PilotData::getFieldData($pilotid, false));

            $pirep_list = PIREPData::getAllReportsForPilot($pilotid);
            $this->set('pireps', $pirep_list);
            $this->set('pirep_list', $pirep_list);

            $this->set('pilotcode', PilotData::getPilotCode($pilot->code, $pilot->pilotid));
            $this->set('allawards', AwardsData::getPilotAwards($pilot->pilotid));

            $this->render('pilot_public_profile.php');
            $this->render('pireps_viewall.php');
	}


	/**
	 * Profile::stats()
	 *
	 * @return
	 */
	public function stats()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

        $this->set('pilot', Auth::$pilot);
		$this->render('profile_stats.php');
	}

	/**
	 * Profile::badge()
	 *
	 * @return
	 */
	public function badge()
	{
		$this->set('badge_url', fileurl(SIGNATURE_PATH.'/'.PilotData::GetPilotCode(Auth::$pilot->code, Auth::$pilot->pilotid).'.png'));
		$this->set('pilotcode', PilotData::getPilotCode(Auth::$pilot->code, Auth::$pilot->pilotid));
		$this->render('profile_badge.php');
	}

	/**
	 * Profile::editprofile()
	 *
	 * @return
	 */
	public function editprofile()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

		$this->set('userinfo', Auth::$pilot);
        	$this->set('pilot', Auth::$pilot);
		$this->set('customfields', PilotData::getFieldData(Auth::$pilotid, true));
		$this->set('bgimages', PilotData::getBackgroundImages());
		$this->set('countries', Countries::getAllCountries());
		$this->set('pilotcode', PilotData::getPilotCode(Auth::$pilot->code, Auth::$pilot->pilotid));

		$this->render('profile_edit.php');
	}

	/**
	 * Profile::changepassword()
	 *
	 * @return
	 */
	public function changepassword()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

		$this->render('profile_changepassword.php');
	}

	/**
	 * Profile::save_profile_post()
	 *
	 * @return
	 */
	protected function save_profile_post()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

		$pilot = Auth::$pilot;

		//TODO: check email validity
		if($this->post->email == '') {
			$this->set('message', 'The email address cannot be blank.');
			$this->render('core_error.php');
			return;
		}
		
		$fields = RegistrationData::getCustomFields();
		
		if(count($fields) > 0) {
            		foreach ($fields as $field) {
				$value = Vars::POST($field->fieldname);
				$value1 = DB::escape($value);
				if ($field->required == 1 && $value1 == '') {
					$this->set('message', ''.$field->title.' cannot be blank!');
					$this->render('core_error.php');
					return;
				} 
			}
		}

		$params = array(
			'code' => $pilot->code,
			'email' => $this->post->email,
			'location' => $this->post->location,
			'hub' => $pilot->hub,
			'bgimage' => $this->post->bgimage,
			'retired' => false
		);

		PilotData::updateProfile($pilot->pilotid, $params);
		PilotData::SaveFields($pilot->pilotid, $_POST);

		# Generate a fresh signature
		PilotData::GenerateSignature($pilot->pilotid);

		PilotData::SaveAvatar($pilot->code, $pilot->pilotid, $_FILES);

		$this->set('message', 'Profile saved!');
		$this->render('core_success.php');
	}

	/**
	 * Profile::change_password_post()
	 *
	 * @return
	 */
	protected function change_password_post()
	{
		if(!Auth::LoggedIn()) {
			$this->set('message', 'You must be logged in to access this feature!');
			$this->render('core_error.php');
			return;
		}

		// Verify
		if($this->post->oldpassword == '') {
			$this->set('message', 'You must enter your current password');
			$this->render('core_error.php');
			return;
		}

		if($this->post->password1 != $this->post->password2) {
			$this->set('message', 'Your passwords do not match');
			$this->render('core_error.php');
			return;
		}

		// Change
		$hash = md5($this->post->oldpassword . Auth::$pilot->salt);

		if($hash == Auth::$pilot->password) {
			RegistrationData::ChangePassword(Auth::$pilotid, $_POST['password1']);
			$this->set('message', 'Your password has been reset');
		} else {
			$this->set('message', 'You entered an invalid password');
		}

		$this->render('core_success.php');
	}
}
