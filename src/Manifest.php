<?php

namespace Caffeinated\Modules;

use Illuminate\Support\Collection;

/**
 * Description of Manifest
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class Manifest
{
    /**
     * @var string $name
     */
    private $name;
    
    /**
     * @var string $basename
     */
    private $basename;
    
    /**
     * @var string $slug
     */
    private $slug;
    
    /**
     * @var string $description
     */
    private $description;
    
    /**
     * @var string $version
     */
    private $version;
    
    /**
     * @var string $routerClass
     */
    private $router;
    
    /**
     * @var string $credentialsClass
     */
    private $credentials;
    
    /**
     * @var Collection $credentialTypes
     */
    private $credentialTypes;
    
    /**
     * @var Collection $strategies
     */
    private $strategies;
    
    /**
     * @var Collection $availableServices
     */
    private $availableServices;
    
    public function __construct(Collection $collection)
    {
        $this->parseFromCollection($collection);
    }
    
    /**
     * Set object values from a passed collection
     * 
     * @param Collection $collection
     */
    private function parseFromCollection(Collection $collection)
    {
        $this->name = $collection->get('name');
        $this->basename = $collection->get('basename');
        $this->slug = $collection->get('slug');
        $this->description = $collection->get('description');
        $this->version = $collection->get('version');
        $this->router = $collection->get('router', 'Router');
        $this->credentials = $collection->get('credentials');
        $this->credentialTypes = collect($collection->get('credentialTypes'));
        $this->strategies = collect($collection->get('strategies'));
        $this->availableServices = collect($collection->get('availableServices'));
    }
    
    public static function create(Collection $collection)
    {
        return new static($collection);
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getBasename()
    {
        return $this->basename;
    }

    public function getSlug()
    {
        return $this->slug;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function getRouter()
    {
        return $this->router;
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    public function getCredentialTypes()
    {
        return $this->credentialTypes;
    }

    public function getStrategies()
    {
        return $this->strategies;
    }

    public function getAvailableServices()
    {
        return $this->availableServices;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setBasename($basename)
    {
        $this->basename = $basename;
    }

    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    public function setRouter($router)
    {
        $this->router = $router;
    }

    public function setCredentials($credentials)
    {
        $this->credentials = $credentials;
    }

    public function setCredentialTypes(Collection $credentialTypes)
    {
        $this->credentialTypes = $credentialTypes;
    }

    public function setStrategies(Collection $strategies)
    {
        $this->strategies = $strategies;
    }

    public function setAvailableServices(Collection $availableServices)
    {
        $this->availableServices = $availableServices;
    }

    public function getManifest()
    {
        return \json_encode(collect([
            'name' => $this->name,
            'basename' => $this->basename,
            'slug' => $this->slug,
            'description' => $this->description,
            'version' => $this->version,
            'router' => $this->router,
            'credentials' => $this->credentials,
            'credentialTypes' => $this->credentialTypes->toArray(),
            'strategies' => $this->strategies->toArray(),
            'availableServices' => $this->availableServices->toArray(),
        ]));
    }

    public function getHostDetails()
    {
        return collect([
            'name' => $this->name,
            'basename' => $this->basename,
            'slug' => $this->slug,
            'description' => $this->description,
            'version' => $this->version,
            'router' => $this->router,
            'credentials' => $this->credentials,
        ]);
    }

}
