<?php

namespace Drupal\arche_mde_api\Model\Metadata;

/**
 * Description of MetadataModel
 *
 * @author nczirjak
 */
class MetadataModel extends \Drupal\arche_mde_api\Model\MainApiModel {

    public function __construct() {
        parent::__construct();
    }

    public function getOntology(string $type): array {
        $dbconnStr = yaml_parse_file(\Drupal::service('extension.list.module')->getPath('acdh_repo_gui') . '/config/config.yaml')['dbConnStr']['guest'];
        $conn = new \PDO($dbconnStr);
        $cfg = (object) [
                    'skipNamespace' => $this->repo->getBaseUrl() . '%', // don't forget the '%' at the end!
                    'ontologyNamespace' => $this->repo->getSchema()->namespaces->ontology,
                    'parent' => $this->repo->getSchema()->namespaces->ontology.'isPartOf',
                    'label' => $this->repo->getSchema()->namespaces->ontology.'hasTitle',
                    'order' => $this->repo->getSchema()->namespaces->ontology.'ordering',
                    'cardinality' => $this->repo->getSchema()->namespaces->ontology.'cardinality',
                    'recommended' => $this->repo->getSchema()->namespaces->ontology.'recommendedClass',
                    'langTag' => $this->repo->getSchema()->namespaces->ontology.'langTag',
                    'vocabs' => $this->repo->getSchema()->namespaces->ontology.'vocabs',
                    'altLabel' => 'http://www.w3.org/2004/02/skos/core#altLabel'
        ];
        $ontology = new \acdhOeaw\arche\lib\schema\Ontology($conn, $cfg);

        return (array) $ontology->getClass($type);
    }

}
