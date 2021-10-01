<?php

namespace Drupal\arche_mde_api\Controller\Metadata;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of MetadataController
 *
 * @author nczirjak
 */
class MetadataController {

    public function execute(string $type, string $lang = "en"): JsonResponse {
        /*
         * Usage:
         *  https://domain.com/browser/api/v2/metadata/type/lang?_format=json
         */
      
        if (!preg_match("/^[a-zA-Z -]+$/", $type)) {
            return new JsonResponse(array("Please provide a valid search string"), 404, ['Content-Type' => 'application/json']);
        }
        
        $object = new \Drupal\arche_mde_api\Object\Metadata\MetadataObject($type, $lang);
        $content = $object->init();

        if (count($content) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }

        return new JsonResponse($content, 200, ['Content-Type' => 'application/json']);
    }

}
