<?php

namespace Admingenerator\GeneratorBundle\Generator;

use Doctrine\Common\Util\Inflector;

/**
 * This class describes an action
 *
 * @author cedric Lombardot
 * @author Piotr Gołębiewski <loostro@gmail.com>
 */
class Action
{
    protected $name;

    protected $type;

    protected $label;

    protected $icon;

    protected $class;
    
    protected $method;

    protected $route;

    protected $submit;

    protected $confirm_message;

    protected $csrf_protected = false;

    protected $crendentials;

    protected $conditional_function;

    protected $conditional_inverse = false;

    protected $params;

    public function __construct($name, $type = 'custom')
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function getLabel()
    {
        if ( isset ($this->label) ) {
            return $this->label;
        }

        return $this->humanize($this->getName());
    }

    public function setIcon($icon)
    {
        $this->icon = $icon;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function setClass($class)
    {
        $this->class = $class;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * If actions is to be CSRF protected, then request method MUST be POST.
     * 
     * CSRF tokens in GET requests are potentially leaked at several locations: 
     * browser history, HTTP log files, network appliances that make a point 
     * to log the first line of an HTTP request, and Referrer headers if the 
     * protected site links to an external site. 
     */
    public function getMethod()
    {
        return $this->getCsrfProtected() ? 'POST' : $this->method;
    }

    public function getRoute()
    {
        return $this->route;
    }

    public function setSubmit($submit)
    {
        $this->submit = (bool) $submit;
    }

    public function isSubmit()
    {
        return $this->submit;
    }

    private function humanize($text)
    {
        return ucfirst(strtolower(str_replace('_', ' ', $text)));
    }

    public function setConfirm($confirm_message)
    {
        $this->confirm_message = $confirm_message;
    }

    public function getConfirm()
    {
        return $this->confirm_message;
    }

    public function setCsrfProtected($csrf_protected)
    {
        $this->csrf_protected = $csrf_protected;
    }

    public function getCsrfProtected()
    {
        return $this->csrf_protected;
    }

    public function setCredentials($crendentials)
    {
        $this->crendentials = $crendentials;
    }

    public function getCredentials()
    {
        return $this->crendentials;
    }

    public function setOption($option, $value)
    {
        $option = Inflector::classify($option);
        call_user_func_array(array($this, 'set'.$option), array($value));
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function setRoute($route)
    {
        $this->route = $route;
    }

    public function setCondition(array $condition)
    {
        if (!isset($condition['function'])) {
            return false;
        }

        $this->conditional_function = $condition['function'];

        if (isset($condition['inverse'])) {
            $this->conditional_inverse = (boolean) $condition['inverse'];
        }
    }

    public function getConditionalFunction()
    {
        return $this->conditional_function;
    }

    public function getConditionalInverse()
    {
        return $this->conditional_inverse;
    }
}
