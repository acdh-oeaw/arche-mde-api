<?php

namespace Drupal\arche_mde_api\Object\Metadata;

/**
 * Description of BaseOntologyObject
 *
 * @author nczirjak
 */
class BaseOntologyObject extends \Drupal\arche_mde_api\Object\MainObject {

    protected $model;
    private $lang;

    public function __construct(string $lang) {
        parent::__construct();
        $this->lang = $lang;
    }
    protected function createModel(): void {
        $this->model = new \Drupal\arche_gui_api\Model\Metadata\MetadataGuiModel();
    }

    public function init(): array {
        $this->createModel();
        return $this->model->getOntology();
    }

}
