<?php

namespace Caffeinated\Modules\Repositories;

use Illuminate\Config\Repository as Config;
use Illuminate\Contracts\Filesystem\Filesystem;

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
     * @var Filesystem $filesystem
     */
    private $filesystem;
    
    public function __construct(Config $config, Filesystem $filesystem)
    {
        $this->config = $config;
        $this->filesystem = $filesystem;
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
    
    /**
     * Get all module basenames.
     *
     * @return array
     */
    public function getAllBasenames()
    {
        $path = $this->getPath();

        try {
            $collection = collect($this->filesystem->directories($path));

            $basenames = $collection->map(function ($item, $key) {
                return basename($item);
            });

            return $basenames;
        } catch (\InvalidArgumentException $e) {
            return collect(array());
        }
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
            $contents   = $this->filesystem->get($path);
            $collection = collect(json_decode($contents, true));

            return $collection;
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
