<?php

namespace Drupal\arche_mde_api\Model;

/**
 * Description of CheckIdentifierModel
 *
 * @author nczirjak
 */
class CheckIdentifierModel extends \Drupal\arche_mde_api\Model\MainApiModel
{
    public function getData(string $searchStr): array
    {
        $result = array();
        //run the actual query
        try {
            $this->setSqlTimeout();
            $query = $this->repodb->query(
                "select 
                        DISTINCT(i.id),  mv.property, mv.value, mv.lang
                    from identifiers as i
                    left join metadata_view as mv on mv.id = i.id
                    where i.id = :repoid
                        and property in (
                        :title,
                        :avdate,
                        :type
                        );",
                array(
                        ':repoid' => $searchStr,
                        ':title' => $this->repo->getSchema()->namespaces->ontology . 'hasTitle',
                        ':avdate' => $this->repo->getSchema()->namespaces->ontology . 'hasAvailableDate',
                        ':type' => 'http://www.w3.org/1999/02/22-rdf-syntax-ns#type'
                    )
            );
            $result = $query->fetchAll(\PDO::FETCH_CLASS);
        } catch (Exception $ex) {
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
