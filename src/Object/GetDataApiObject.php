<?php

namespace Drupal\arche_mde_api\Object;

/**
 * Description of GetDataApiObject
 *
 * @author nczirjak
 */
class GetDataApiObject extends \Drupal\arche_mde_api\Object\MainObject {

    private $type;
    
    public function __construct(string $type, string $searchStr) {
        parent::__construct($searchStr);
        $this->createModel();
        $this->formatSearchValues($type, $searchStr);
    }
    
    protected function createModel(): void {
        $this->model = new \Drupal\arche_mde_api\Model\GetDataApiModel();
    } 
    
    public function init(): array {
        return $this->formatView($this->model->getData($this->str, $this->type));
    }

    private function formatSearchValues(string $type, string $searchStr): void {
        $this->type = $this->repo->getSchema()->namespaces->ontology.ucfirst($type);
        $this->str = strtolower($searchStr);        
    }
}
