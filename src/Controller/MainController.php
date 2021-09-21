<?php
namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

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
    public function api_persons(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\PersonsController();
        return $controller->execute($searchStr);
    }
    
    /**
     * ACDH:Concepts for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_concepts(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\ConceptsController();
        return $controller->execute($searchStr);
    }
    
    /**
     * ACDH:Places for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_places(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\PlacesController();
        return $controller->execute($searchStr);
    }
    
    /**
     * ACDH:Publications for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_publications(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\PublicationsController();
        return $controller->execute($searchStr);
    }
    
    /**
     * ACDH:Organisations for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_organisations(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\OrganisationsController();
        return $controller->execute($searchStr);
    }
    
    /**
     * ACDH:Organisations for metadata editor
     * @param string $searchStr
     * @return Response
     */
    public function api_check_identifier(string $searchStr): JsonResponse
    {   
        $controller = new \Drupal\arche_mde_api\Controller\CheckIdentifierController();
        return $controller->execute($searchStr);
    }
    
    
    
    
}
