<?php

namespace Drupal\arche_mde_api\Object;

/**
 * Description of PlacesObject
 *
 * @author nczirjak
 */
class PlacesObject extends \Drupal\arche_mde_api\Object\MainObject {

    public function __construct(string $searchStr) {
        parent::__construct($searchStr);
        $this->createModel();
    }
    
    protected function createModel(): void {
        $this->model = new \Drupal\arche_mde_api\Model\PlacesModel();
    } 

}