<?php

namespace Caffeinated\Modules\Repositories;

use Caffeinated\Modules\Contracts\Repository;
use Caffeinated\Modules\Repositories\ModuleFilesystem;
use Illuminate\Database\Eloquent\Model;

/**
 * Database-based module repository
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class EloquentRepository implements Repository
{
    /**
     * @var ModuleFilesystem $moduleFiles 
     */
    private $moduleFiles;
    
    /**
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    private $model;
    
    public function __construct(ModuleFilesystem $moduleFiles)
    {
        $this->moduleFiles = $moduleFiles;
    }
    
    /**
     * Set the model to use for database operations
     * 
     * @param Model $model
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }
    
    /**
     * Retrieve a model by slug and set a property if it exists
     * 
     * @param string $slug
     * @param string $property
     * @param mixed $value
     */
    protected function setPropertyBySlug($slug, $property, $value)
    {
        $model = $this->model->where('slug', $slug)->get();
        if ($model) {
            $model->$property = $value;
            $model->save();
        }
    }
    
    /**
     * Get a value from a module by slug
     * 
     * @param string $slug
     * @param string $property
     * @param mixed $default
     * 
     * @return mixed
     */
    protected function getPropertyBySlug($slug, $property, $default = null)
    {
        $model = $this->model->where('slug', $slug)->get();
        return $model ? $model[$property] : $default;        
    }
    
    public function all()
    {
        return $this->model->all();
    }

    public function count()
    {
        return $this->model->all()->count();
    }

    public function disable($slug)
    {
        $this->setPropertyBySlug($slug, 'enabled', false);
    }

    public function disabled()
    {
        return $this->model->where('enabled', false)->get();
    }

    public function enable($slug)
    {
        $this->setPropertyBySlug($slug, 'enabled', true);
    }

    public function enabled()
    {
        return $this->model->where('enabled', true)->get();
    }

    public function exists($slug)
    {
        return ($this->model->where('slug', $slug)->count() > 0);
    }

    public function get($property, $default = null)
    {
        list($slug, $prop) = explode('::', $property);
        return $this->getPropertyBySlug($slug, $prop, $default);
    }

    public function getManifest($slug)
    {
        return $this->getPropertyBySlug($slug, 'manifest');
    }

    public function isDisabled($slug)
    {
        return !($this->getPropertyBySlug($slug, 'enabled'));
    }

    public function isEnabled($slug)
    {
        return $this->getPropertyBySlug($slug, 'enabled');
    }

    public function optimize()
    {
        $manifests = $this->moduleFiles->getAllManifests();
        foreach ($manifests as $basename => $manifest) {
            $modelDetails = [
                'name' => $manifest['name'],
                'slug' => $manifest['slug'],
                'description' => $manifest['description'],
                'version' => $manifest['version'],
                'manifest' => $manifest->toJson(),
                'router' => $manifest->get('router', 'Router'),
                'credentials' => $manifest->get('credentials', null),
            ];
            $model = $this->model->firstOrNew(['basename' => $basename]);
            $model->fill($modelDetails);
            $model->save();
        }
    }

    public function set($property, $value)
    {
        list($slug, $prop) = explode('::', $property);
        $this->setPropertyBySlug($slug, $prop, $value);
    }

    public function slugs()
    {
        return $this->all()->pluck('slug');
    }

    public function sortBy($key)
    {
        return $this->model->orderBy($key, 'asc')->all();
    }

    public function sortByDesc($key)
    {
        return $this->model->orderBy($key, 'desc')->all();
    }

    public function where($key, $value)
    {
        return $this->model->where($key, $value)->get();
    }

}
