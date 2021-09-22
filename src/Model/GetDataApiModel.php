<?php

namespace Drupal\arche_mde_api\Model;

/**
 * Description of OrganisationsModel
 *
 * @author nczirjak
 */
class GetDataApiModel extends \Drupal\arche_mde_api\Model\MainApiModel {
    
    public function getData(string $searchStr, string $type): array {
        $result = array();
        //run the actual query
        try {
            $this->setSqlTimeout('10000');
            $query = $this->repodb->query(
                    "SELECT * from gui.apiGetData(:type, :searchStr)",
                    array(
                        ':type' => $type,
                        ':searchStr' => $searchStr
                    ),
                    ['allow_delimiter_in_query' => true, 'allow_square_brackets' => true]
            );

            $result = $query->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_GROUP);
        } catch (\Exception $ex) {
            \Drupal::logger('arche_gui_api')->notice($ex->getMessage());
            $result = array();
        } catch (\Drupal\Core\Database\DatabaseExceptionWrapper $ex) {
            \Drupal::logger('arche_gui_api')->notice($ex->getMessage());
            $result = array();
        }

        $this->changeBackDBConnection();
        return $result;
    }
    
}
