<?php

namespace Caffeinated\Modules\Manifests;

use Illuminate\Support\Collection;

/**
 * Description of CredentialTypeElementOption
 *
 * @author Matthew Weir <mweir@sitelock.com>
 */
class CredentialTypeElementOption
{
    /**
     * @var string $value
     */
    private $value;
    
    /**
     * @var string $text
     */
    private $text;
    
    /**
     * @var boolean $default
     */
    private $default;
    
    /**
     * @var string $placeholder
     */
    private $placeholder;
    
    public function __construct(Collection $data)
    {
        $this->text = $data->get('text');
        $this->value = $data->get('value');
        $this->default = $data->get('default', false);
        $this->placeholder = $data->get('placeholder');
    }
    
    public function getValue()
    {
        return $this->value;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getDefault()
    {
        return $this->default;
    }

    public function getPlaceholder()
    {
        return $this->placeholder;
    }

}
