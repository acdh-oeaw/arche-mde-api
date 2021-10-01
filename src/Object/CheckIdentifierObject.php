<?php

namespace Drupal\arche_mde_api\Object;

/**
 * Description of CheckIdentifierObject
 *
 * @author nczirjak
 */
class CheckIdentifierObject extends \Drupal\arche_mde_api\Object\MainObject {

    public function __construct(string $searchStr) {
        parent::__construct();
        $this->str = strtolower($searchStr);
        $this->createModel();
    }

    protected function createModel(): void {
        $this->model = new \Drupal\arche_mde_api\Model\CheckIdentifierModel();
    }

    protected function formatView(array $data): array { {
            $this->result = array();
            
            foreach ($data as $val) {
                if ($val->property == 'https://vocabs.acdh.oeaw.ac.at/schema#hasAvailableDate') {
                    $this->result['hasAvailableDate'] = date('Y-m-d', strtotime($val->value));
                }
                if ($val->property == 'https://vocabs.acdh.oeaw.ac.at/schema#hasTitle') {
                    $this->result['title'] = $val->value;
                }
                if ($val->property == 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type') {
                    $this->result['rdfType'] = $val->value;
                }
            }

            return $this->result;
        }
    }
}
    