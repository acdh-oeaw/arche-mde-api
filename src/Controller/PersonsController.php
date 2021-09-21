<?php

namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of PersonsController
 *
 * @author nczirjak
 */
class PersonsController {

    public function execute(string $searchStr): JsonResponse {
        /*
         * Usage:
         *  https://domain.com/browser/api/mde/persons/MYVALUE?_format=json
         */

        if (empty($searchStr)) {
            return new JsonResponse(array("Please provide a search string"), 404, ['Content-Type' => 'application/json']);
        }

        $object = new \Drupal\arche_mde_api\Object\PersonsObject($searchStr);
        $object->init();

        if (count($object->getData()) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }
       
        
        return new JsonResponse($object->getData(), 200, ['Content-Type' => 'application/json']);
    }

}
