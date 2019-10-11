<?php

namespace Drupal\request_form\Controller;

use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/*
*	A custom access check
*/
class RequestFormController {

	public function access(AccountInterface $account){

		if($account->isAnonymous()) {
			return AccessResult::forbidden();
		}

		return AccessResult::allowed();
	}
}