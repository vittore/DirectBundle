<?php

namespace Ext\DirectBundle\Request;

use \Ext\DirectBundle\Exception\InvalidJsonException;

/**
 * Class CallForm
 *
 * @package Ext\DirectBundle\Request
 *
 * @author  Semyon Velichko <semyon@velichko.net>
 */
class CallForm extends Call
{

    /**
     * The ExtDirect upload reference.
     * 
     * @var boolean
     */
    protected $isUpload;

    /**
     * @return bool
     */
    public function getIsUpload()
    {
        return $this->isUpload;
    }

    /**
     * Initialize the call properties from a form call.
     *
     * @param array $call
     *
     * @throws \Ext\DirectBundle\Exception\InvalidJsonException
     */
    public function initialize($call)
    {
        foreach (array('action' => 'extAction',
                      'method' => 'extMethod',
                      'type' => 'extType',
                      'tid' => 'extTID',
                      'isUpload' => 'extUpload') as $key => $value) {
            if (!isset($call[$value])) {
                throw new InvalidJsonException(sprintf('%s key does not exist', $value));
            }

            $this->$key = $call[$value];
            unset($call[$value]);
        }

        foreach ($call as $key => $value) {
            $this->data[$key] = $value;
        }

        if ($this->getIsUpload()) {
            $this->data = array_merge($this->data, $this->request->getFiles());
        }

    }

}
