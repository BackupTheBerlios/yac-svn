<?php
/**
 * Groupware configuration file
 *
 * This file contains the main configuration of the groupware
 *
 * @package Groupware
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 * @version 1.0
 * @copyright Copyright (c) 2003-2005
 * @license http://opensource.org/licenses/gpl-license.php GNU General Public License
 */


 /**
 * If the Groupware is active
 *
 * @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
 *
 * @var bool
 */
define("GROUPWARE_ISACTIVE", true);

/**
* Message displayed if Groupware is not active
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var string
*/
define("GROUPWARE_NOTACTIVE", "Siamo spiacenti, ma il servizio è momentaneamente disattivato per interventi tecnici. Siete pregati di ritornare più tardi");

/**
* Text of the social contract (DO NOT EDIT!)
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var string
*/
define("GROUPWARE_CONTRACT", implode("", file("misc/groupware/documents/contract.html")));

/**
* Text of Disclamer (DO NOT EDIT!)
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var string
*/
#define("GROUPWARE_DISCLAMER", implode("", file("misc/groupware/documents/disclamer.html")));

/**
* Allow guest to create new projects
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var bool
*/
define("GROUPWARE_ALLOW_GUEST", false);

/**
* If is a Guest, will be displayed this message.
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var bool
*/
define("GROUPWARE_ALLOW_GUEST_TEXT", "Siamo spiacenti ma per motivi di sicurezza non possiamo permetterle di usufruire di questa funzione a meno che non abbia eseguito il login con il suo account.");

/**
* Groupware Module Path
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var string
*/
define("GROUPWARE_MOD_PATH", "Groupware/");

/**
* XML comment
*
* @author Giovanni Piller Cottrer <giovanni.piller@gmail.com>
*
* @var string
*/
define("XML_CLASS_COMMENT", wordwrap("\nThis XML file is maked using XML Class.\nXML Class is developed by Giovanni Piller Cottrer <giovanni.piller@gmail.com for Flatnuke project.\nTo help me developing this class, you can visit my site: http://gigasoft.altervista.org\n"), 80);

?>