<?php

/**
 * Manage FAQs
 *
 * @package     Nails
 * @subpackage  module-faq
 * @category    Controller
 * @author      Nails Dev Team
 * @link
 */

namespace Nails\Admin\Faq;

use Nails\Factory;
use Nails\Admin\Helper;
use Nails\Admin\Controller\Base;

class Faq extends Base
{
    /**
     * Announces this controller's navGroups
     * @return stdClass
     */
    public static function announce()
    {
        if (userHasPermission('admin:faq:faq:manage')) {

            $navGroup = Factory::factory('Nav', 'nailsapp/module-admin');
            $navGroup->setLabel('FAQs');
            $navGroup->setIcon('fa-question-circle');
            $navGroup->addAction('Manage FAQs');

            return $navGroup;
        }
    }

    // --------------------------------------------------------------------------

    /**
     * Returns an array of extra permissions for this controller
     * @return array
     */
    public static function permissions()
    {
        $permissions = parent::permissions();

        $permissions['manage'] = 'Can manage faqs';
        $permissions['create'] = 'Can create faqs';
        $permissions['edit']   = 'Can edit faqs';
        $permissions['delete'] = 'Can delete faqs';

        return $permissions;
    }

    // --------------------------------------------------------------------------

    /**
     * Constructs the controller
     */
    public function __construct()
    {
        parent::__construct();

        // --------------------------------------------------------------------------

        $this->lang->load('admin_faq');
    }

    // --------------------------------------------------------------------------

    /**
     * Browse faqs
     * @return void
     */
    public function index()
    {
        if (!userHasPermission('admin:faq:faq:manage')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oFaqModel = Factory::model('Faq', 'nailsapp/module-faq');

        // --------------------------------------------------------------------------

        //  Set method info
        $this->data['page']->title = lang('faqs_index_title');

        // --------------------------------------------------------------------------

        $tablePrefix = $oFaqModel->getTablePrefix();

        //  Get pagination and search/sort variables
        $page      = $this->input->get('page')      ? $this->input->get('page')      : 0;
        $perPage   = $this->input->get('perPage')   ? $this->input->get('perPage')   : 50;
        $sortOn    = $this->input->get('sortOn')    ? $this->input->get('sortOn')    : $tablePrefix . '.order';
        $sortOrder = $this->input->get('sortOrder') ? $this->input->get('sortOrder') : 'asc';
        $keywords  = $this->input->get('keywords')  ? $this->input->get('keywords')  : '';

        // --------------------------------------------------------------------------

        //  Define the sortable columns
        $sortColumns = array(
            $tablePrefix . '.created'  => 'Created Date',
            $tablePrefix . '.modified' => 'Modified Date',
            $tablePrefix . '.group'    => 'group',
            $tablePrefix . '.order'    => 'Order'
        );

        // --------------------------------------------------------------------------

        //  Define the $data variable for the queries
        $data = array(
            'sort' => array(
                array($sortOn, $sortOrder)
            ),
            'keywords' => $keywords
        );

        //  Get the items for the page
        $totalRows          = $oFaqModel->countAll($data);
        $this->data['faqs'] = $oFaqModel->getAll($page, $perPage, $data);

        //  Set Search and Pagination objects for the view
        $this->data['search']     = Helper::searchObject(true, $sortColumns, $sortOn, $sortOrder, $perPage, $keywords);
        $this->data['pagination'] = Helper::paginationObject($page, $perPage, $totalRows);

        //  Add a header button
        if (userHasPermission('admin:faq:faq:create')) {

            Helper::addHeaderButton(
                'admin/faq/faq/create',
                lang('faqs_nav_create')
            );
        }

        // --------------------------------------------------------------------------

        Helper::loadView('index');
    }

    // --------------------------------------------------------------------------

    /**
     * Create a new faq
     * @return void
     */
    public function create()
    {
        if (!userHasPermission('admin:faq:faq:create')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = lang('faqs_create_title');

        // --------------------------------------------------------------------------

        if ($this->input->post()) {

            $oFormValidation = Factory::service('FormValidation');
            $oFormValidation->set_rules('label', '', 'xss_clean|required');
            $oFormValidation->set_rules('group', '', 'xss_clean|required');
            $oFormValidation->set_rules('body', '', 'xss_clean|required');
            $oFormValidation->set_rules('order', '', 'xss_clean|required|is_natural');

            $oFormValidation->set_message('required', lang('fv_required'));
            $oFormValidation->set_message('is_natural', lang('fv_is_natural'));

            if ($oFormValidation->run()) {

                $aInsertData          = array();
                $aInsertData['label'] = $this->input->post('label');
                $aInsertData['group'] = $this->input->post('group');
                $aInsertData['body']  = $this->input->post('body');
                $aInsertData['order'] = (int) $this->input->post('order');

                $oFaqModel = Factory::model('Faq', 'nailsapp/module-faq');

                if ($oFaqModel->create($aInsertData)) {

                    $this->session->set_flashdata('success', lang('faqs_create_ok'));
                    redirect('admin/faq/faq/index');

                } else {

                    $this->data['error'] = lang('faqs_create_fail');
                }

            } else {

                $this->data['error'] = lang('fv_there_were_errors');
            }
        }

        // --------------------------------------------------------------------------

        //  Load views
        Helper::loadView('edit');
    }

    // --------------------------------------------------------------------------

    /**
     * Edit a faq
     * @return void
     */
    public function edit()
    {
        if (!userHasPermission('admin:faq:faq:edit')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oFaqModel = Factory::model('Faq', 'nailsapp/module-faq');

        $this->data['faq'] = $oFaqModel->getById($this->uri->segment(5));

        if (!$this->data['faq']) {

            $this->session->set_flashdata('error', lang('faqs_common_bad_id'));
            redirect('admin/faq/faq/index');
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = lang('faqs_edit_title');

        // --------------------------------------------------------------------------

        if ($this->input->post()) {

            $oFormValidation = Factory::service('FormValidation');
            $oFormValidation->set_rules('label', '', 'xss_clean|required');
            $oFormValidation->set_rules('group', '', 'xss_clean|required');
            $oFormValidation->set_rules('body', '', 'xss_clean|required');
            $oFormValidation->set_rules('order', '', 'xss_clean|required|is_natural');

            $oFormValidation->set_message('required', lang('fv_required'));
            $oFormValidation->set_message('is_natural', lang('fv_is_natural'));

            if ($oFormValidation->run()) {

                $data          = array();
                $data['label'] = $this->input->post('label');
                $data['group'] = $this->input->post('group');
                $data['body']  = $this->input->post('body');
                $data['order'] = (int) $this->input->post('order');

                if ($oFaqModel->update($this->data['faq']->id, $data)) {

                    $this->session->set_flashdata('success', lang('faqs_edit_ok'));
                    redirect('admin/faq/faq/index');

                } else {

                    $this->data['error'] = lang('faqs_edit_fail');
                }

            } else {

                $this->data['error'] = lang('fv_there_were_errors');
            }
        }

        // --------------------------------------------------------------------------

        //  Load views
        Helper::loadView('edit');
    }

    // --------------------------------------------------------------------------

    /**
     * Delete a faq
     * @return void
     */
    public function delete()
    {
        if (!userHasPermission('admin:faq:faq:delete')) {

            unauthorised();
        }

        // --------------------------------------------------------------------------

        $oFaqModel = Factory::model('Faq', 'nailsapp/module-faq');

        $faq = $oFaqModel->getById($this->uri->segment(5));

        if (!$faq) {

            $this->session->set_flashdata('error', lang('faqs_common_bad_id'));
            redirect('admin/faq/faq/index');
        }

        // --------------------------------------------------------------------------

        if ($oFaqModel->delete($faq->id)) {

            $this->session->set_flashdata('success', lang('faqs_delete_ok'));

        } else {

            $this->session->set_flashdata('error', lang('faqs_delete_fail'));
        }

        // --------------------------------------------------------------------------

        redirect('admin/faq/faq/index');
    }
}
