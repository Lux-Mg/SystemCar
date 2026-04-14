<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Sistema extends CI_Controller{

    public function __construct(){

        parent::__construct();

        if(!$this->ion_auth->logged_in()){
            redirect('login'); 
        }

        $this->lang->load('sistema', 'english');

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', $this->lang->line('no_permission_system_menu'));
            redirect('/');
        }
    }  

    public function index(){

        $this->form_validation->set_rules('sistema_razao_social', $this->lang->line('corporate_name'), 'trim|required|min_length[4]|max_length[145]');
        $this->form_validation->set_rules('sistema_nome_fantasia', $this->lang->line('trade_name'), 'trim|required|min_length[4]|max_length[145]');
        // Permite internacional: +, números, espacios, paréntesis, guiones, de 10 a 18 caracteres
        $this->form_validation->set_rules(
            'sistema_telefone_movel',
            $this->lang->line('mobile_phone'),
            'trim|required|min_length[10]|max_length[18]|regex_match[/^\+?[0-9\-\(\)\s]+$/]'
        );
        $this->form_validation->set_rules('sistema_endereco', $this->lang->line('address'), 'trim|required|min_length[4]|max_length[145]');
        $this->form_validation->set_rules('sistema_numero', $this->lang->line('number'), 'trim|required|min_length[1]|max_length[25]');
        $this->form_validation->set_rules('sistema_texto_ticket', $this->lang->line('ticket_text'), 'trim|max_length[200]');

        if ($this->form_validation->run()) {

            $data = elements(
                array(
                    'sistema_razao_social',
                    'sistema_nome_fantasia',
                    'sistema_telefone_movel',
                    'sistema_endereco',
                    'sistema_numero',
                    'sistema_texto_ticket',
                ), $this->input->post()
            );

            //Sanitize array
            $data = html_escape($data);

            $this->core_model->update('sistema', $data, array('sistema_id' => 1));

            $this->session->set_flashdata('sucesso', $this->lang->line('data_saved_successfully'));

            redirect($this->router->fetch_class());

        } else {

            $data = array(
                'titulo' => $this->lang->line('edit_system_info'),
                'sub_titulo' => $this->lang->line('edit_system_info_subtitle'),
                'icone_view' => 'ik ik-settings',
                'sistema' => $this->core_model->get_by_id('sistema', array('sistema_id' => 1)),
                'scripts' => array(
                    'plugins/mask/jquery.mask.min.js',
                    'plugins/mask/custom.js',
                ),
            );

            $this->load->view('layout/header', $data);
            $this->load->view('sistema/index');
            $this->load->view('layout/footer');
        }
    }
}