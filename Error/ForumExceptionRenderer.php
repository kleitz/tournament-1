<?php
/**
 * @copyright	Copyright 2006-2013, Miles Johnson - http://milesj.me
 * @license		http://opensource.org/licenses/mit-license.php - Licensed under the MIT License
 * @link		http://milesj.me/code/cakephp/tournament
 */

App::uses('ExceptionRenderer', 'Error');
App::uses('TournamentAppController', 'Tournament.Controller');

class TournamentExceptionRenderer extends ExceptionRenderer {

	/**
	 * Get the controller instance to handle the exception.
	 * Override this method in subclasses to customize the controller used.
	 * This method returns the built in `CakeErrorController` normally, or if an error is repeated
	 * a bare controller will be used.
	 *
	 * @param Exception $exception The exception to get a controller for.
	 * @return Controller
	 */
	protected function _getController($exception) {
		if (!$request = Router::getRequest(true)) {
			$request = new CakeRequest();
		}

		// If outside of plugin, use default handling
		if ($request->params['plugin'] !== 'tournament') {
			return parent::_getController($exception);
		}

		$response = new CakeResponse(array('charset' => Configure::read('App.encoding')));

		$controller = new TournamentAppController($request, $response);
		$controller->viewPath = 'Errors';
		$controller->constructClasses();
		$controller->startupProcess();

		return $controller;
	}

}