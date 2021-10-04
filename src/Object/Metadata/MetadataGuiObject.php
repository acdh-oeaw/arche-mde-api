<?php

namespace Drupal\arche_mde_api\Object\Metadata;

/**
 * Description of MetadataObject
 *
 * @author nczirjak
 */
class MetadataGuiObject extends \Drupal\arche_mde_api\Object\MainObject
{
    protected $model;
    private $lang;

    public function __construct(string $lang)
    {
        parent::__construct();
        $this->lang = $lang;
    }
    protected function createModel(): void
    {
        $this->model = new \Drupal\arche_mde_api\Model\Metadata\MetadataGuiModel();
    }

    public function init(): array
    {
        $this->createModel();
        return $this->processData($this->model->getOntology());
    }

   
    private function processData(array $data): array
    {
        $helper = new \Drupal\arche_mde_api\Helper\Metadata\MetadataGuiHelper();
        return $helper->getData($data);
    }
}
