<?php

namespace Drupal\request_form\Plugin\Condition;

use Drupal\node\Entity;
/**
 * Provides a 'Node is review' condition.
 *
 * @Condition(
 *   id = "rules_node_type_is_review",
 *   label = @Translation("Node type is review"),
 *   category = @Translation("Node"),
 *   context = {
 *     "node" = @ContextDefinition("entity:node",
 *       label = @Translation("Node")
 *     )
 *   }
 * )
 */
class NodeIsReview extends RulesConditionBase {

  /**
   * Check if the given node type is review.
   *
   * @param \Drupal\node\NodeInterface $node
   *   The node to check.
   *
   * @return bool
   *   TRUE if the node is sticky.
   */
  protected function doEvaluate(NodeInterface $node) {

    if($node->getType() == 'review')
    return true;
  
  else return false;
  }

}