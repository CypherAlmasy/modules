<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Description of CredentialTypeElement
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class CredentialTypeElement
{
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @var string $property_name
     */
    private $property_name;
    
    /**
     * @var string $description
     */
    private $description;
    
    /**
     * @var string $input_type
     */
    private $input_type;
    
    /**
     * @var string $placeholder
     */
    private $placeholder;
    
    /**
     * @var boolean $optional
     */
    private $optional;
    
    /**
     * @var array $rules
     */
    private $rules;
    
    /**
     * @var Collection $options
     */
    private $options;
    
    public function __construct(
        Collection $data,
        Collection $options
    ) {
        $this->name = $data->get('name');
        $this->description = $data->get('description');
        $this->property_name = $data->get('property_name');
        $this->placeholder = $data->get('placeholder');
        $this->input_type = $data->get('input_type');
        $this->optional = $data->get('optional');
        $this->rules = $data->get('rules');
        $this->options = $options;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getPropertyName()
    {
        return $this->property_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getInputType()
    {
        return $this->input_type;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

    public function getOptional()
    {
        return $this->optional;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function getOptions()
    {
        return $this->options;
    }

}
