<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Description of Strategy
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class Strategy
{
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @var string $class_name
     */
    private $class_name;
    
    /**
     * @var string $description
     */
    private $description;
    
    /**
     * @var string $service
     */
    private $service;
    
    public function __construct(Collection $data)
    {
        $this->name = $data->get('name');
        $this->class_name = $data->get('class_name');
        $this->description = $data->get('description');
        $this->service = $data->get('service');
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getClassName()
    {
        return $this->class_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getService()
    {
        return $this->service;
    }

}
