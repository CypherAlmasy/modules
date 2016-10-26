<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Description of Manifest
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class Host
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
     * @var string $manifest
     */
    private $manifest;
    
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
     * @var array $credentialTypes
     */
    private $credentialTypes;
    
    /**
     * @var array $strategies
     */
    private $strategies;
    
    /**
     * @param Collection $collection
     * @param CredentialType[] $credentialTypes
     * @param Strategy[] $strategies
     */
    public function __construct(
        Collection $collection,
        Collection $credentialTypes,
        Collection $strategies
    ) {
        $this->parseFromCollection($collection);
        $this->credentialTypes = $credentialTypes;
        $this->strategies = $strategies;
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
        $this->manifest = $collection->get('manifest');
        $this->version = $collection->get('version');
        $this->router = $collection->get('router', 'Router');
        $this->credentials = $collection->get('credentials');
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

    public function getManifest()
    {
        return $this->manifest;
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
    
}
