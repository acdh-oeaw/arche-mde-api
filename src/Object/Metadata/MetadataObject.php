<?php

namespace Drupal\arche_mde_api\Object\Metadata;

/**
 * Description of MetadataObject
 *
 * @author nczirjak
 */
class MetadataObject extends \Drupal\arche_mde_api\Object\MainObject
{
    protected $model;
    private $type;
    private $lang;
    private $data = array();
    private $properties;

    public function __construct(string $type, string $lang)
    {
        parent::__construct();
        $this->type = $type;
        $this->lang = $lang;
    }

    protected function createModel(): void
    {
        $this->model = new \Drupal\arche_mde_api\Model\Metadata\MetadataModel();
    }

    public function init(): array
    {
        $this->createModel();
        $this->addNamespaceToType();
        return $this->processData($this->model->getOntology($this->type, $this->lang));
    }

    /**
     * load and process the model data
     * @param array $data
     * @return array
     */
    private function processData(array $data): array
    {
        $this->result = array();
        //if we dont have properties then we dont have data
        if ($this->initData($data) === false) {
            return array();
        }

        $this->creatMetadataObj($data);
        $this->createHeader();

        $this->formatMetadataView();

        return $this->result;
    }

    /**
     * change the type to the acdh format
     * @return void
     */
    private function addNamespaceToType(): void
    {
        $this->type = $this->repodb->getSchema()->namespaces->ontology . ucfirst($this->type);
    }

    /**
     * Init the properties
     * @param array $data
     * @return bool
     */
    private function initData(array $data): bool
    {
        if (isset($data['properties']) && count((array) $data['properties']) > 0) {
            $this->data = $data['properties'];
            return true;
        }
        return false;
    }

    /**
     * Create the response header
     * @return void
     */
    private function createHeader(): void
    {
        $this->result['$schema'] = "http://json-schema.org/draft-07/schema#";
        $this->result['id'] = $this->properties->class;
        $this->result['type'] = "object";
        $this->result['title'] = str_replace($this->repodb->getSchema()->namespaces->ontology, '', $this->properties->class);
    }

    /**
     * Create properties obj with values from the metadata api request
     * @param array $data
     */
    private function creatMetadataObj(array $data)
    {
        $this->properties = new \stdClass();

        if (isset($data['class'])) {
            $this->properties->class = $data['class'];
        }
        if (isset($data['label'])) {
            $this->properties->label = $data['label'];
        }
        if (isset($data['comment'])) {
            $this->properties->comment = $data['comment'];
        }
    }

    /**
     * Format the data for the metadata api request
     */
    private function formatMetadataView(): void
    {
        foreach ($this->data as $v) {
            $prop = $this->setUpPropertyValue($v);
           
            if (isset($v->label) && isset($v->label[$this->siteLang])) {
                $this->result['properties'][$prop]['title'] = $v->label[$this->siteLang];
            }
            if (isset($v->comment) && isset($v->comment[$this->siteLang])) {
                $this->result['properties'][$prop]['description'] = $v->comment[$this->siteLang];
                $this->result['properties'][$prop]['attrs']['placeholder'] = $v->comment[$this->siteLang];
            }

            $this->setUpRange($v, $prop);
            $this->checkCardinality($prop, $v);

            //order missing!
            $this->result['properties'][$prop]['order'] = 0;
            if (isset($v->order) && $v->order) {
                $this->result['properties'][$prop]['order'] = (int) $v->order;
            }

            //recommendedClass missing!
            if (isset($v->recommendedClass) && $v->recommendedClass) {
                $this->result['properties'][$prop]['recommendedClass'] = $v->recommendedClass;
            }
        }
        if (count((array) $this->requiredClasses) > 0) {
            $this->result['required'] = $this->requiredClasses;
        }
    }

    /**
     * Check the property cardinalities
     *
     * @param array $data
     * @return string
     */
    private function checkCardinality(string $prop, object $obj)
    {
        $this->setUpMinCardinality($obj, $prop);

        $this->setUpMaxCardinality($obj, $prop);

        if (isset($obj->min) && $obj->min >= 1) {
            $this->requiredClasses[] = $prop;
        }

        if (isset($obj->cardinality)) {
            $this->result['properties'][$prop]['cardinality'] = $obj->cardinality;
            $this->result['properties'][$prop]['minItems'] = (int) $obj->cardinality;
            $this->result['properties'][$prop]['maxItems'] = (int) $obj->cardinality;
        }
    }

    /**
     * Set up the response property values
     * @param array $v
     * @return string
     */
    private function setUpPropertyValue(object $v): string
    {
        if (is_array($v->property)) {
            foreach ($v->property as $key => $value) {
                if (strpos($value, $this->repodb->getSchema()->namespaces->ontology) !== false) {
                    return str_replace($this->repodb->getSchema()->namespaces->ontology, '', $value);
                }
            }
        }
        return str_replace($this->repodb->getSchema()->namespaces->ontology, '', $v->property);
    }

    /**
     * Set up the range value
     * @param object $v
     * @return void
     */
    private function setUpRange(object $v, string $prop): void
    {
        if (isset($v->range)) {
            $range = "";
            $rangeUrl = "";
            foreach ($v->range as $key => $value) {
                if (strpos($value, 'http://www.w3.org/2001/XMLSchema#') !== false) {
                    $range = str_replace('http://www.w3.org/2001/XMLSchema#', '', $value);
                    $rangeUrl = $value;
                }
            }
            $this->result['properties'][$prop]['items']['range'] = $rangeUrl;
            if (strpos($range, 'string') !== false) {
                $this->result['properties'][$prop]['items']['type'] = "string";
                $this->result['properties'][$prop]['type'] = "string";
            }
            if (strpos($range, 'array') !== false) {
                $this->result['properties'][$prop]['items']['type'] = "array";
                $this->result['properties'][$prop]['type'] = "array";
            }
        }
    }

    private function setUpMinCardinality(object $obj, string $prop): void
    {
        if (isset($obj)) {
            $this->result['properties'][$prop]['minItems'] = (int) $obj->min;
            if ($obj->min >= 1) {
                $this->result['properties'][$prop]['type'] = "array";
            }
            if ($obj->min == 1) {
                $this->result['properties'][$prop]['uniqueItems'] = true;
            }
        } else {
            $this->result['properties'][$prop]['minItems'] = 0;
        }
    }

    private function setUpMaxCardinality(object $obj, string $prop): void
    {
        if (isset($obj->max)) {
            $this->result['properties'][$prop]['maxItems'] = (int) $obj->max;
            if ($obj->max > 1) {
                $this->result['properties'][$prop]['type'] = "array";
            }
        }
    }
}
