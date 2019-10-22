<?php

namespace Drupal\request_form\Plugin\Condition;

use Drupal\node\Entity;
/**
 * Provides a 'User has role' condition.
 *
 * @Condition(
 *   id = "rules_user_has_role",
 *   label = @Translation("User has role"),
 *   category = @Translation("Node"),
 *   context = {
 *     "user" = @ContextDefinition("user",
 *       label = @Translation("User")
 *     )
 *   }
 * )
 */
class UserHasRole extends RulesConditionBase {

  /**
   * Check if the user has role company.
   *
   * @param \Drupal\core\Session\AccountInterface $user
   *   The user to check.
   *
   * @return bool
   *   TRUE if the node is sticky.
   */
  protected function doEvaluate(UserInterface $user) {

    
    return $user->hasRole('c');//or not machine name of role?
  }

}