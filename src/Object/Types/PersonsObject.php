<?php

namespace Drupal\arche_mde_api\Object\Types;

/**
 * Description of PersonsObject
 *
 * @author nczirjak
 */
class PersonsObject extends \Drupal\arche_mde_api\Object\MainObject {

    public function __construct(string $searchStr) {
        parent::__construct();
        $this->str = strtolower($searchStr);
        $this->createModel();
    }
    
    protected function createModel(): void {
        $this->model = new \Drupal\arche_mde_api\Model\Types\PersonsModel();
    } 

}