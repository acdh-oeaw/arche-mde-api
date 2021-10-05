<<<<<<< HEAD
<?php

namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Description of MainController
 *
 * @author nczirjak
 */
class MainController extends \Drupal\Core\Controller\ControllerBase {

    /**
     * ACDH:Perons for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_persons(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Types\PersonsController();
        return $controller->execute($searchStr);
    }

    /**
     * ACDH:Concepts for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_concepts(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Types\ConceptsController();
        return $controller->execute($searchStr);
    }

    /**
     * ACDH:Places for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_places(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Types\PlacesController();
        return $controller->execute($searchStr);
    }

    /**
     * ACDH:Publications for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_publications(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Types\PublicationsController();
        return $controller->execute($searchStr);
    }

    /**
     * ACDH:Organisations for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_organisations(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Types\OrganisationsController();
        return $controller->execute($searchStr);
    }

    /**
     * get property data for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_getData(string $type, string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\GetDataApiController();
        return $controller->execute($type, $searchStr);
    }

    /**
     * Check acdh identifiers in the DB for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_check_identifier(string $searchStr): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\CheckIdentifierController();
        return $controller->execute($searchStr);
    }

    /**
     * Display the ontology data by the given property name. F.e.: Person
     * @param string $type
     * @param string $lang
     * @return JsonResponse
     */
    public function api_getMetadata(string $type, string $lang): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Metadata\MetadataController();
        return $controller->execute($type, $lang);
    }

    /**
     * List Collection/project/Resource ontology
     * @param string $lang
     * @return JsonResponse
     */
    public function api_baseOntology(string $lang): JsonResponse {
        $controller = new \Drupal\arche_mde_api\Controller\Metadata\BaseOntologyController();
        return $controller->execute($lang);
    }

}
