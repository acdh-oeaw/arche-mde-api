<?php

namespace Drupal\arche_mde_api\Model\Metadata;

/**
 * Description of RootTableModel
 *
 * @author nczirjak
 */
class RootTableModel extends \Drupal\arche_mde_api\Model\MainApiModel {

    public function __construct() {
        parent::__construct();
    }

    public function getData(): array {
        $dbconnStr = yaml_parse_file(\Drupal::service('extension.list.module')->getPath('acdh_repo_gui') . '/config/config.yaml')['dbConnStr']['guest'];
        $conn = new \PDO($dbconnStr);
        $cfg = (object) [
                    'skipNamespace' => $this->properties->baseUrl . '%', // don't forget the '%' at the end!
                    'ontologyNamespace' => $this->repo->getSchema()->namespaces->ontology,
                    'parent' => $this->repo->getSchema()->namespaces->ontology.'isPartOf',
                    'label' => $this->repo->getSchema()->namespaces->ontology.'hasTitle',
                    'order' => $this->repo->getSchema()->namespaces->ontology.'ordering',
                    'cardinality' => $this->repo->getSchema()->namespaces->ontology.'cardinality',
                    'recommended' => $this->repo->getSchema()->namespaces->ontology.'recommendedClass',
                    'langTag' => $this->repo->getSchema()->namespaces->ontology.'langTag',
                    'vocabs' => $this->repo->getSchema()->namespaces->ontology.'vocabs',
                    'label' => 'http://www.w3.org/2004/02/skos/core#altLabel'
        ];

        $ontology = new \acdhOeaw\arche\lib\schema\Ontology($conn, $cfg);

        //check the properties
        $project = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Project')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Project')->properties : "";

        $collection = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Collection')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Collection')->properties : "";

        $topCollection = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'TopCollection')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'TopCollection')->properties : "";

        $resource = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Resource')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Resource')->properties : "";

        $metadata = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Metadata')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Metadata')->properties : "";


        $image = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Image')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Image')->properties : "";

        $publication = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Publication')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Publication')->properties : "";

        $place = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Place')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Place')->properties : "";


        $organisation = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Organisation')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Organisation')->properties : "";

        $person = (isset($ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Person')->properties)) ?
                $ontology->getClass($this->repo->getSchema()->namespaces->ontology.'Person')->properties : "";

        return array(
            'project' => $project,
            'topcollection' => $topCollection, 'collection' => $collection,
            'resource' => $resource, 'metadata' => $metadata,
            'publication' => $publication,
            'place' => $place, 'organisation' => $organisation,
            'person' => $person
        );
    }

}
