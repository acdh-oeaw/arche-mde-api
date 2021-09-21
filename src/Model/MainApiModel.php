<?php

namespace Drupal\arche_mde_api\Model;

/**
 * Description of ArcheApiModel
 *
 * @author nczirjak
 */
class MainApiModel {
    
    protected $repodb;
    protected $config;
    protected $repo;
    
    public function __construct()
    {
        $this->config = \Drupal::service('extension.list.module')->getPath('acdh_repo_gui') . '/config/config.yaml';
        try {
            $this->repo = \acdhOeaw\arche\lib\Repo::factory($this->config);
        } catch (\Exception $ex) {
            \Drupal::messenger()->addWarning($this->t('Error during the BaseController initialization!').' '.$ex->getMessage());
            return array();
        }
        //set up the DB connections
        $this->setActiveConnection();
    }

    /**
     * Allow the DB connection
     */
    protected function setActiveConnection()
    {
        \Drupal\Core\Database\Database::setActiveConnection('repo');
        $this->repodb = \Drupal\Core\Database\Database::getConnection('repo');
    }

    protected function changeBackDBConnection()
    {
        \Drupal\Core\Database\Database::setActiveConnection();
    }

    /**
     * Set the sql execution max time
     * @param string $timeout
     */
    public function setSqlTimeout(string $timeout = '7000')
    {
        $this->setActiveConnection();

        try {
            $this->repodb->query(
                "SET statement_timeout TO :timeout;",
                array(':timeout' => $timeout)
            )->fetch();
        } catch (Exception $ex) {
            \Drupal::logger('arche_mde_api')->notice($ex->getMessage());
        } catch (\Drupal\Core\Database\DatabaseExceptionWrapper $ex) {
            \Drupal::logger('arche_mde_api')->notice($ex->getMessage());
        }
    }
}
