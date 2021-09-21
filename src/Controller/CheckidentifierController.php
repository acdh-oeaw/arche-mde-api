<?php

namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of ConceptsController
 * API endpoint for METADATA Editor 
 *
 * @author nczirjak
 */
class CheckidentifierController {
   
    public function execute(string $searchStr): Response {
        /*
         * Usage:
         *  https://domain.com/browser/api/mde/checkIdentifier/MYVALUE?_format=json
         */

        if (empty($searchStr)) {
            return new JsonResponse(array("Please provide a repo id"), 404, ['Content-Type' => 'application/json']);
        }
        
        $object = new \Drupal\arche_mde_api\Object\ConceptsObject($searchStr);
        if($object->init() === false) {
            return new JsonResponse(array("Init error!"), 404, ['Content-Type' => 'application/json']);
        }
        
        if (count($object->getData()) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }
        return new JsonResponse(json_encode($object->getData()), 200, ['Content-Type' => 'application/json']);
    }
    
}
