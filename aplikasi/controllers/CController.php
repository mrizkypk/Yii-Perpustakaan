<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;

/**
 * BukuController implements the CRUD actions for Buku model.
 */
class CController extends Controller
{
    public function __construct($id, $module, $config = []) {
		parent::__construct($id, $module, $config);

		if (!isset($_SESSION['admin']) && !isset($_GET['root'])) {
			$url = Url::home(true) . 'site/masuk?root=ya';
			return $this->redirect($url);
		}
    }
}