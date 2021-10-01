<?php

namespace Drupal\arche_mde_api\Model\Types;

/**
 * Description of PlacesModel
 *
 * @author nczirjak
 */
class PlacesModel extends \Drupal\arche_mde_api\Model\MainApiModel {
    
    public function getData(string $searchStr): array
    {
       
        $result = array();
        //run the actual query
        try {
            $this->setSqlTimeout('10000');
            $query = $this->repodb->query(
                "SELECT * from gui.apiGetData(:type, :searchStr)",
                array(
                    ':type' => $this->repo->getSchema()->namespaces->ontology.'Place',
                    ':searchStr' => strtolower($searchStr)
                ),
                ['allow_delimiter_in_query' => true, 'allow_square_brackets' => true]
            );
            
            $result = $query->fetchAll(\PDO::FETCH_CLASS|\PDO::FETCH_GROUP);
        } catch (\Exception $ex) {
            \Drupal::logger('arche_mde_api')->notice($ex->getMessage());
            $result = array();
        } catch (\Drupal\Core\Database\DatabaseExceptionWrapper $ex) {
            \Drupal::logger('arche_mde_api')->notice($ex->getMessage());
            $result = array();
        }
        
        $this->changeBackDBConnection();
        return $result;
    }
    
}
