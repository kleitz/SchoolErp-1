<?php
/**
 * Created by PhpStorm.
 * User: Akshat
 * Date: 7/20/2017
 * Time: 12:26 PM
 */
class Accounts extends MY_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('get_header_info','ghi');
        $username = $this->ghi->get_admin();
        $this->load->view('private/accounts/header',['username'=>$username]);
        $this->load->view('private/accounts/footer');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
    }


    public function account_group()
    {
        //To be replaced with passing parameters from view dynamically
        //goal: one controller and one module for complete genric Creation.
        $form_validation='account_group';
        $table_name='account_group';
        $view='account_group';
        $field='account_group_name';
        $this->insert_genric($form_validation,$table_name,$view,$field);
    }
    public function account_group_del()
    {
        if ($this->form_validation->run('account_gr_delete')) {

            $post = $this->input->post();
            unset($post['del_account_group']);
            $this->load->model('del_model', 'dm');
            $value = $post['account_group_delete'];
            $table_name='account_group';
            $field='account_group_name';
            if($this->dm->delete_row($table_name,$field,$value)){
                $this->load->model('get_model', 'gm');
                $list= $this->gm->get_list($field,$table_name);
                $this->load->view('private/accounts/account_group',['view' => $list]);
            }
        }
        else{
            $table_name='account_group';
            $field='account_group_name';
            $this->load->model('get_model', 'gm');
            $list= $this->gm->get_list($field,$table_name);
            $this->load->view('private/accounts/account_group',['view' => $list]);
        }
    }



    public function index(){
    }
    public function new_account(){
        $field_a='account_group_name';
        $table_name_a='account_group';
        $this->load->model('get_model','gm');
        $group= $this->gm->get_list($field_a,$table_name_a);
        $this->load->view('private/accounts/new_account',['group'=>$group]);
    }
    public function send_sms(){
        $this->load->view('private/accounts/send_sms');
    }
    public function import(){
        $this->load->view('private/accounts/import');
    }
    public function export(){
        $this->load->view('private/accounts/export');
    }
    public function labels(){
        $this->load->view('private/accounts/labels');
    }

    public function open_balance_editor()
    {
        $this->load->view('private/accounts/open_balance_editor');
    }
    public function delete(){
        $this->load->view('private/accounts/delete');
    }
    public function insert_genric($form_validation,$table_name,$view,$field)
    {
        if ($this->form_validation->run($form_validation)) {

            // for inserting class in database from model

            $this->load->model('add_model', 'am');
            $post = $this->input->post();
            unset($post['submit']);
            if ($this->am->insert_data($table_name,$post)) {
                $this->load->model('get_model', 'gm');
                $array = $this->gm->get_list($field,$table_name);
                $this->load->view('private/accounts/'.$view,['view'=>$array]);
            } else {
                echo 'Query failed in inserting record';
            }
        } else {
            $this->load->model('get_model', 'gm');
            $array = $this->gm->get_list($field,$table_name);
            $this->load->view('private/accounts/'.$view,['view'=>$array]);
        }
    }
}