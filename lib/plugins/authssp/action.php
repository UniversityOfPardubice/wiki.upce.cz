<?php

/**
 * DokuWiki Plugin authshibboleth (Action Component)
 *
 * Intercepts the 'login' action and redirects the user to the Shibboleth Session Initiator Handler
 * instead of showing the login form.
 * 
 * @author  Ivan Novakov http://novakov.cz/
 * @license http://debug.cz/license/bsd-3-clause BSD 3 Clause 
 * @link https://github.com/ivan-novakov/dokuwiki-shibboleth-auth
 */

// must be run within Dokuwiki
if (! defined('DOKU_INC'))
    die();

if (! defined('DOKU_LF'))
    define('DOKU_LF', "\n");
if (! defined('DOKU_TAB'))
    define('DOKU_TAB', "\t");
if (! defined('DOKU_PLUGIN'))
    define('DOKU_PLUGIN', DOKU_INC . 'lib/plugins/');

require_once DOKU_PLUGIN . 'action.php';


class action_plugin_authssp extends DokuWiki_Action_Plugin
{

    public function register(Doku_Event_Handler &$controller)
    {
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'doSimpleSAMLLogin');
    }


    public function doSimpleSAMLLogin($event, $param)
    {
        global $ACT;
        
        if ('login' == $ACT) {

            // loading of simplesamlphp library
            global $conf;
            require_once($conf['ssp_path'] . '/lib/_autoload.php');
            $as = new SimpleSAML_Auth_Simple('default-sp');
            $as->requireAuth();
        }
    }
}
