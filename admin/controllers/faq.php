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

class Faq extends \AdminController
{
    /**
     * Announces this controller's navGroups
     * @return stdClass
     */
    public static function announce()
    {
        if (userHasPermission('admin:faq:faq:manage')) {

            $navGroup = new \Nails\Admin\Nav('FAQs', 'fa-question-circle');
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

        $this->load->model('faq/faq_model');
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

        //  Set method info
        $this->data['page']->title = lang('faqs_index_title');

        // --------------------------------------------------------------------------

        $tablePrefix = $this->faq_model->getTablePrefix();

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
        $totalRows          = $this->faq_model->count_all($data);
        $this->data['faqs'] = $this->faq_model->get_all($page, $perPage, $data);

        //  Set Search and Pagination objects for the view
        $this->data['search']     = \Nails\Admin\Helper::searchObject(true, $sortColumns, $sortOn, $sortOrder, $perPage, $keywords);
        $this->data['pagination'] = \Nails\Admin\Helper::paginationObject($page, $perPage, $totalRows);

        //  Add a header button
        if (userHasPermission('admin:faq:faq:create')) {

             \Nails\Admin\Helper::addHeaderButton(
                'admin/faq/faq/create',
                lang('faqs_nav_create')
            );
        }

        // --------------------------------------------------------------------------

        \Nails\Admin\Helper::loadView('index');
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

            $this->load->library('form_validation');

            $this->form_validation->set_rules('label', '', 'xss_clean|required');
            $this->form_validation->set_rules('group', '', 'xss_clean|required');
            $this->form_validation->set_rules('body', '', 'xss_clean|required');
            $this->form_validation->set_rules('order', '', 'xss_clean|required|is_natural');

            $this->form_validation->set_message('required', lang('fv_required'));
            $this->form_validation->set_message('is_natural', lang('fv_is_natural'));

            if ($this->form_validation->run()) {

                $data          = array();
                $data['label'] = $this->input->post('label');
                $data['group'] = $this->input->post('group');
                $data['body']  = $this->input->post('body');
                $data['order'] = (int) $this->input->post('order');

                if ($this->faq_model->create($data)) {

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
        \Nails\Admin\Helper::loadView('edit');
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

        $this->data['faq'] = $this->faq_model->get_by_id($this->uri->segment(5));

        if (!$this->data['faq']) {

            $this->session->set_flashdata('error', lang('faqs_common_bad_id'));
            redirect('admin/faq/faq/index');
        }

        // --------------------------------------------------------------------------

        //  Page Title
        $this->data['page']->title = lang('faqs_edit_title');

        // --------------------------------------------------------------------------

        if ($this->input->post()) {

            $this->load->library('form_validation');

            $this->form_validation->set_rules('label', '', 'xss_clean|required');
            $this->form_validation->set_rules('group', '', 'xss_clean|required');
            $this->form_validation->set_rules('body', '', 'xss_clean|required');
            $this->form_validation->set_rules('order', '', 'xss_clean|required|is_natural');

            $this->form_validation->set_message('required', lang('fv_required'));
            $this->form_validation->set_message('is_natural', lang('fv_is_natural'));

            if ($this->form_validation->run()) {

                $data          = array();
                $data['label'] = $this->input->post('label');
                $data['group'] = $this->input->post('group');
                $data['body']  = $this->input->post('body');
                $data['order'] = (int) $this->input->post('order');

                if ($this->faq_model->update($this->data['faq']->id, $data)) {

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
        \Nails\Admin\Helper::loadView('edit');
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

        $faq = $this->faq_model->get_by_id($this->uri->segment(5));

        if (!$faq) {

            $this->session->set_flashdata('error', lang('faqs_common_bad_id'));
            redirect('admin/faq/faq/index');
        }

        // --------------------------------------------------------------------------

        if ($this->faq_model->delete($faq->id)) {

            $this->session->set_flashdata('success', lang('faqs_delete_ok'));

        } else {

            $this->session->set_flashdata('error', lang('faqs_delete_fail'));
        }

        // --------------------------------------------------------------------------

        redirect('admin/faq/faq/index');
    }
}
