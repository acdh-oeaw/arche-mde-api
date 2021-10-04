<?php

namespace Drupal\arche_mde_api\Controller\Metadata;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of BaseOntologyController
 *
 * @author nczirjak
 */
class BaseOntologyController {
    
    public function execute(string $lang = "en"): JsonResponse {
        /*
         * Usage:
         *  https://domain.com/browser/api/mde/baseOntology/lang?_format=json
         */

        $object = new \Drupal\arche_mde_api\Object\Metadata\BaseOntologyObject($lang);
        $content = $object->init();

        if (count($content) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }

        return new JsonResponse($content, 200, ['Content-Type' => 'application/json']);
    }
}
