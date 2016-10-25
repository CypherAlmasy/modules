<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Parses JSON string from a module's module.json to obtain related manifest
 * objects
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class Parser
{
    /**
     * @var array $data
     */
    private $data; 
    
    /**
     * @var Host $manifestObject
     */
    private $manifestObject = null;
    
    /**
     * @param array $manifest Should be valid JSON
     */
    public function __construct(Collection $manifest)
    {
        $this->data = $manifest;
    }
    
    /**
     * Get a host manifest object
     * 
     * @return \Caffeinated\Modules\Manifests\Host
     */
    public function manifest()
    {
        if (is_null($this->manifestObject)) { 
            $this->manifestObject = new Host(
                $this->data,
                $this->credentialTypeManifests(),
                $this->strategyManifests()
            );
        }
        return $this->manifestObject;
    }
    
    /**
     * Get a collection of CredentialType manifests for the host
     * 
     * @return Collection
     */
    private function credentialTypeManifests()
    {
        $types = collect();
        foreach ($this->data['credentialTypes'] as $type) {
            $types->push($this->createCredentialTypeManifest($type));
        }
        return $types;
    }
    
    /**
     * Create a CredentialType manifest object from array data
     * 
     * @param array $data
     */
    private function createCredentialTypeManifest(array $data)
    {
        $elements = collect();
        foreach ($data['elements'] as $element) {
            $elements->push(
                $this->createCredentialTypeElementManifest($element)
            );
        }
        
        return new CredentialType(collect($data), $elements);
    }
    
    /**
     * Create a CredentialTypeElement manifest object from array data
     * 
     * @param array $data
     * 
     * @return \Caffeinated\Modules\Manifests\CredentialTypeElement
     */
    private function createCredentialTypeElementManifest(array $data)
    {
        $options = collect();
        if (isset($data['options'])) {
            foreach ($data['options'] as $option) {
                $options->push(
                    new CredentialTypeElementOption(collect($option))
                );
            }
        }
        
        return new CredentialTypeElement(collect($data), $options);
    }
    
    private function strategyManifests()
    {
        $strategies = collect();
        foreach ($this->data['strategies'] as $strategy) {
            $strategies->push(new Strategy(collect($strategy)));
        }
        return $strategies;
    }
    
}
