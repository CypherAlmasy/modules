<?php

namespace Caffeinated\Modules\Repositories;

use Illuminate\Config\Repository as Config;
use File;

/**
 * Description of ModuleFilesystem
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class ModuleFilesystem
{
    /**
     * @var Config $config
     */
    private $config;
    
    /**
     * @var string $path
     */
    private $path;
    
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Get modules path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path ?: $this->config->get('modules.path');
    }
    
    public function setPath($path)
    {
        $this->path = $path;
    }
    
    /**
     * Get all module basenames.
     *
     * @return array
     */
    public function getAllBasenames()
    {
        $path = $this->getPath();
        $collection = collect(File::directories($path));
        $basenames = $collection->map(function ($item) {
            return File::basename($item);
        });

        return $basenames;
    }

    public function getAllManifests()
    {
        $manifests = array();
        foreach ($this->getAllBasenames() as $basename) {
            $manifests[$basename] = $this->getManifest($basename);
        }
        return collect($manifests);
    }
    
    /**
     * Get modules namespace.
     *
     * @return string
     */
    public function getNamespace()
    {
        return rtrim($this->config->get('modules.namespace'), '/\\');
    }

    /**
     * Get a module's manifest contents.
     *
     * @param string $basename
     *
     * @return Collection|null
     */
    public function getManifest($basename)
    {
        if (! is_null($basename)) {
            $path       = $this->getManifestPath($basename);
            $contents   = File::get($path);
            return collect(json_decode($contents, true));
        }

        return;
    }
    
    /**
     * Get path of module manifest file.
     *
     * @param $basename
     *
     * @return string
     */
    protected function getManifestPath($basename)
    {
        return $this->getModulePath($basename).'module.json';
    }
    
    /**
     * Get path for the specified module.
     *
     * @param string $basename
     *
     * @return string
     */
    public function getModulePath($basename)
    {
        return $this->getPath(). '/' . $basename . '/';
    }
    
}
