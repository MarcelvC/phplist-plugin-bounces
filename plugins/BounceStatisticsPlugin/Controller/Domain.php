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
 * This class is a subclass of the base controller class, which implements the CommonPlugin_IPopulator
 * interface to show bounces by domain
 * 
 */
class BounceStatisticsPlugin_Controller_Domain
    extends BounceStatisticsPlugin_Controller
    implements CommonPlugin_IPopulator, CommonPlugin_IExportable
{
    /*
     * Implementation of CommonPlugin_IPopulator
     */

    function populate(WebblerListing $w, $start, $limit)
    {
        $w->setTitle($this->i18n->get('domain name'));

        foreach ($this->model->listBounceDomains($start, $limit) as $row) {
            $key = $row['domain'];
            $w->addElement($key);
            $w->addColumn($key, $this->i18n->get('bounces'), $row['bounces']);
        }
    }

    function total()
    {
        return $this->model->totalBounceDomains();
    }

    /*
     * Implementation of CommonPlugin_IExportable
     */
    public function exportRows()
    {
        return $this->model->listBounceDomains();
    }

    public function exportFieldNames()
    {
        return array(
            $this->i18n->get('domain name'),
            $this->i18n->get('bounces')
        );
    }

    public function exportValues(array $row)
    {
        return array(
            $row['domain'],
            $row['bounces']
        );
    }
}
