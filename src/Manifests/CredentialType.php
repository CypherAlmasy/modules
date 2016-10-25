<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Description of CredentialType
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class CredentialType
{
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @var string $description
     */
    private $description;
    
    /**
     * @var CredentialTypeElement[] $elements
     */
    private $elements;
    
    public function __construct(
        Collection $data,
        Collection $elements
    ) {
        $this->name = $data->get('name');
        $this->description = $data->get('description');
        $this->elements = $elements;
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getElements()
    {
        return $this->elements;
    }

}
