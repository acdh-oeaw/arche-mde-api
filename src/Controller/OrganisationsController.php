<?php

namespace Drupal\arche_mde_api\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Description of OrganisationsController
 *
 * @author nczirjak
 */
class OrganisationsController {

    public function execute(string $searchStr): Response {
        /*
         * Usage:
         *  https://domain.com/browser/api/v2/organisation/MYVALUE?_format=json
         */

        if (empty($searchStr)) {
            return new JsonResponse(array("Please provide a search string"), 404, ['Content-Type' => 'application/json']);
        }

        $object = new \Drupal\arche_mde_api\Object\OrganisationsObject($searchStr);
        $object->init();

        if (count($object->getData()) == 0) {
            return new JsonResponse(array("There is no resource"), 404, ['Content-Type' => 'application/json']);
        }
        return new JsonResponse(json_encode($object->getData()), 200, ['Content-Type' => 'application/json']);
    }

}
