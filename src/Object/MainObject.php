<?php

namespace Drupal\arche_mde_api\Object;

/**
 * Description of MainObject
 *
 * @author nczirjak
 */
class MainObject
{
    protected $result = array();
    protected $str = "";
    protected $model;
    protected $repo;
    protected $repodb;

    public function __construct()
    {
        (isset($_SESSION['language'])) ? $this->siteLang = strtolower($_SESSION['language']) : $this->siteLang = "en";

        $this->config = \Drupal::service('extension.list.module')->getPath('acdh_repo_gui') . '/config/config.yaml';

        try {
            $this->repo = \acdhOeaw\arche\lib\Repo::factory($this->config);
            $this->repodb = \acdhOeaw\arche\lib\RepoDb::factory($this->config);
        } catch (\Exception $ex) {
            \Drupal::messenger()->addWarning($this->t('Error during the BaseController initialization!') . ' ' . $ex->getMessage());
            return array();
        }
    }

    protected function createModel(): void
    {
        $this->model = new \stdClass();
    }

    public function init(): array
    {
        return $this->formatView($this->model->getData($this->str));
    }

    public function getData(): array
    {
        return $this->result;
    }

    protected function formatView(array $data): array
    {
        $this->result = array();
        foreach ($data as $k => $val) {
            foreach ($val as $v) {
                if (isset($v->value) && !empty($v->value)) {
                    $title = $v->value;
                    $lang = $v->lang;
                    $altTitle = '';
                    if ($v->property == $this->repo->getSchema()->namespaces->ontology . 'hasAlternativeTitle') {
                        $altTitle = $v->value;
                    }

                    $this->result[$k] = new \stdClass();
                    $this->result[$k]->title[$lang] = $title;
                    $this->result[$k]->uri = $this->repo->getBaseUrl() . $k;
                    $this->result[$k]->identifier = $k;
                    $this->result[$k]->altTitle = $altTitle;
                }
            }
        }
        return $this->result = array_values($this->result);
    }
}
