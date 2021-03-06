<?php
/**
 * BounceStatisticsPlugin for phplist
 * 
 * This file is a part of BounceStatisticsPlugin.
 *
 * @category  phplist
 * @package   BounceStatisticsPlugin
 * @author    Duncan Cameron
 * @copyright 2011-2013 Duncan Cameron
 * @license   http://www.gnu.org/licenses/gpl.html GNU General Public License, Version 3
 */

/**
 * This is the controller class that provides the actionX() methods
 */
class BounceStatisticsPlugin_Controller
    extends CommonPlugin_Controller
{
    protected $model;

    /*
     *    Protected methods
     */
    protected function actionDefault()
    {
        if (isset($_POST['SearchForm'])) {
            $this->model->setProperties($_POST['SearchForm']);
            $redirect = new CommonPlugin_PageURL;
            header("Location: $redirect");
            exit;
        }

        $toolbar = new CommonPlugin_Toolbar($this);
        $toolbar->addExportButton();
        $toolbar->addHelpButton($this->model->page);
        $listing = new CommonPlugin_Listing($this, $this);
        $params = array(
            'toolbar' => $toolbar->display(),
            'listing' => $listing->display()
        );

        if (($this->model->page == 'reason' || $this->model->page == 'users') && count($this->model->attributes) > 0)
            $params['form'] = CommonPlugin_Widget::attributeForm($this, $this->model, false, true);

        print $this->render(dirname(__FILE__) . '/view.tpl.php', $params);
    }

    /*
     *    Public methods
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new BounceStatisticsPlugin_Model(new CommonPlugin_DB());
        $this->model->setProperties($_REQUEST);
    }

    public function exportFileName()
    {
        return "bounces_{$this->model->page}";
    }
}
