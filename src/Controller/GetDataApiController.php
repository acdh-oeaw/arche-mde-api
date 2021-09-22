<?php

namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of GetDataApiController
 * API endpoint for METADATA Editor 
 *
 * @author nczirjak
 */
class GetDataApiController {
   
    public function execute(string $type, string $searchStr): Response {
        /*
         * Usage:
         *  https://domain.com/browser/api/mde/getData/TYpe/MYVALUE?_format=json
         */

        if (empty($searchStr)) {
            return new JsonResponse(array("Please provide a type and a search string"), 404, ['Content-Type' => 'application/json']);
        }
        
        $object = new \Drupal\arche_mde_api\Object\GetDataApiObject($type, $searchStr);
        $object->init();
        
        if (count($object->getData()) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }
        return new JsonResponse($object->getData(), 200, ['Content-Type' => 'application/json']);
    }
    
}
