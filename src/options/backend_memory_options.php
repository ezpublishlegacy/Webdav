<?php
/**
 * File containing the ezcWebdavMemoryBackendOptions class
 *
 * @package Webdav
 * @version //autogen//
 * @copyright Copyright (C) 2005-2007 eZ systems as. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 * @access private
 */

/**
 * Class containing the options for the memory backend.
 *
 * @property bool $fakeLiveProperties
 *           Indicates weather memory backend should try to fake live
 *           properties instead of just returning null if a property not has
 *           been set.
 * @property string $failForRegexp
 *           Let operation fail for all ressource paths mathing this regular
 *           expression. The exact handling of this option depends on the
 *           operation this option is used with.
 * @property int $failingOperations
 *           Operations which should respect the failForRegexp property. May be
 *           a bitmask of webdav request type constants.
 *
 * @package Webdav
 * @version //autogen//
 * @access private
 */
class ezcWebdavMemoryBackendOptions extends ezcBaseOptions
{
    /**
     * Constructs an object with the specified values.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if $options contains a property not defined
     * @throws ezcBaseValueException
     *         if $options contains a property with a value not allowed
     * @param array(string=>mixed) $options
     */
    public function __construct( array $options = array() )
    {
        $this->properties['fakeLiveProperties'] = false;
        $this->properties['failForRegexp']      = null;
        $this->properties['failingOperations']  = 0;

        parent::__construct( $options );
    }

    /**
     * Sets the option $name to $value.
     *
     * @throws ezcBasePropertyNotFoundException
     *         if the property $name is not defined
     * @throws ezcBaseValueException
     *         if $value is not correct for the property $name
     * @param string $name
     * @param mixed $value
     * @ignore
     */
    public function __set( $name, $value )
    {
        switch ( $name )
        {
            case 'fakeLiveProperties':
                if ( !is_bool( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'bool' );
                }

                $this->properties[$name] = $value;
                break;

            case 'failForRegexp':
                if ( !is_string( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'regular expression' );
                }

                $this->properties[$name] = $value;
                break;

            case 'failingOperations':
                if ( !is_int( $value ) )
                {
                    throw new ezcBaseValueException( $name, $value, 'integer' );
                }

                $this->properties[$name] = $value;
                break;

            default:
                throw new ezcBasePropertyNotFoundException( $name );
        }
    }
}
?>