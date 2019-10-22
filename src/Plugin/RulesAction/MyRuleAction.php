<?php

namespace Drupal\request_form\Plugin\RulesAction;
/**
 * Provides a 'Show a message' action.
 *
 * @RulesAction(
 *   id = "rules_show_message",
 *   label = @Translation("Show message"),
 *   category = @Translation("Message"),
 *   context = {
 *     "user" = @ContextDefinition("entity",
 *       label = @Translation("Entity"),
 *       description = @Translation("Specifies the entity, which should be deleted permanently.")
 *     )
 *   }
 * )
 */
class MyRuleAction extends RulesActionBase {

  /**
   * Deletes the Entity.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   *    The entity to be deleted.
   */
  protected function doExecute(EntityInterface $entity) {
    $entity->delete();
  }

}