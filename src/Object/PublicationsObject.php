<?php

namespace Drupal\arche_mde_api\Object;

/**
 * Description of PublicationsObject
 *
 * @author nczirjak
 */
class PublicationsObject extends \Drupal\arche_mde_api\Object\MainObject {

    public function __construct(string $searchStr) {
        parent::__construct($searchStr);
        $this->createModel();
    }
    
    protected function createModel(): void {
        $this->model = new \Drupal\arche_mde_api\Model\PublicationsModel();
    } 

}