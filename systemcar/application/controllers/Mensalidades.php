<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Mensalidades extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('mensalidades_model');
        $this->lang->load('mensalidades', 'english');
    }

    public function index() {
        $data = array(
            'titulo' => $this->lang->line('registered_monthly_payments'),
            'sub_titulo' => $this->lang->line('listing_registered_monthly_payments'),
            'icone_view' => 'fas fa-hand-holding-usd',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'mensalidades' => $this->mensalidades_model->get_all(),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('mensalidades/index');
        $this->load->view('layout/footer');
    }

    public function core($mensalidade_id = NULL) {
        if (!$mensalidade_id) {
            // Creating new monthly payment

            $this->form_validation->set_rules('mensalidade_mensalista_id', $this->lang->line('monthly_client'), 'required');
            $this->form_validation->set_rules('mensalidade_precificacao_id', $this->lang->line('category'), 'required');
            $this->form_validation->set_rules(
                'mensalidade_data_vencimento',
                $this->lang->line('due_date'),
                'required|callback_check_existe_mensalidade|callback_check_data_valida|callback_check_data_com_dia_vencimento'
            );

            if ($this->form_validation->run()) {

                $data = elements(
                    array(
                        'mensalidade_mensalista_id',
                        'mensalidade_precificacao_id',
                        'mensalidade_valor_mensalidade',
                        'mensalidade_mensalista_dia_vencimento',
                        'mensalidade_data_vencimento',
                        'mensalidade_status',
                    ), $this->input->post()
                );

                $data['mensalidade_mensalista_id'] = $this->input->post('mensalidade_mensalista_hidden_id');
                $data['mensalidade_precificacao_id'] = $this->input->post('mensalidade_precificacao_hidden_id');

                if ($data['mensalidade_status'] == 1) {
                    $data['mensalidade_data_pagamento'] = date('Y-m-d H:i:s');
                }

                $data = html_escape($data);

                $this->core_model->insert('mensalidades', $data);
                redirect($this->router->fetch_class());

            } else {
                // Validation error
                $data = array(
                    'titulo' => $this->lang->line('register_monthly_payment'),
                    'sub_titulo' => $this->lang->line('registering_monthly_payments'),
                    'icone_view' => 'fas fa-hand-holding-usd',
                    'texto_modal' => $this->lang->line('are_you_sure_save'),
                    'styles' => array(
                        'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
                        'plugins/select2/dist/css/select2.min.css',
                    ),
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js',
                        'plugins/select2/dist/js/select2.min.js',
                        'js/mensalidades/mensalidades.js',
                    ),
                    'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                    'mensalistas' => $this->core_model->get_all('mensalistas', array('mensalista_ativo' => 1)),
                );

                $this->load->view('layout/header', $data);
                $this->load->view('mensalidades/core');
                $this->load->view('layout/footer');
            }

        } else {

            if (!$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))) {
                $this->session->set_flashdata('error', $this->lang->line('monthly_payment_not_found'));
                redirect($this->router->fetch_class());
            } else {

                $this->form_validation->set_rules('mensalidade_precificacao_id', $this->lang->line('category'), 'required');

                if ($this->form_validation->run()) {

                    $data = elements(
                        array(
                            'mensalidade_precificacao_id',
                            'mensalidade_valor_mensalidade',
                            'mensalidade_mensalista_dia_vencimento',
                            'mensalidade_status',
                        ), $this->input->post()
                    );

                    $data['mensalidade_mensalista_id'] = $this->input->post('mensalidade_mensalista_hidden_id');
                    $data['mensalidade_precificacao_id'] = $this->input->post('mensalidade_precificacao_hidden_id');

                    if ($data['mensalidade_status'] == 1) {
                        $data['mensalidade_data_pagamento'] = date('Y-m-d H:i:s');
                    }

                    $data = html_escape($data);

                    $this->core_model->update('mensalidades', $data, array('mensalidade_id' => $mensalidade_id));
                    redirect($this->router->fetch_class());

                } else {
                    // Validation error
                    $data = array(
                        'titulo' => $this->lang->line('edit_monthly_payment'),
                        'sub_titulo' => $this->lang->line('editing_monthly_payments'),
                        'icone_view' => 'fas fa-hand-holding-usd',
                        'texto_modal' => $this->lang->line('are_you_sure_save'),
                        'styles' => array(
                            'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
                            'plugins/select2/dist/css/select2.min.css',
                        ),
                        'scripts' => array(
                            'plugins/mask/jquery.mask.min.js',
                            'plugins/mask/custom.js',
                            'plugins/select2/dist/js/select2.min.js',
                            'js/mensalidades/mensalidades.js',
                        ),
                        'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                        'mensalistas' => $this->core_model->get_all('mensalistas', array('mensalista_ativo' => 1)),
                        'mensalidade' => $this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id)),
                    );

                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalidades/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_data_com_dia_vencimento($mensalidade_data_vencimento) {
        if ($mensalidade_data_vencimento) {
            $mensalidade_data_vencimento = explode('-', $mensalidade_data_vencimento);
            $mensalidade_mensalista_dia_vencimento = $this->input->post('mensalidade_mensalista_dia_vencimento');

            if ($mensalidade_data_vencimento[2] != $mensalidade_mensalista_dia_vencimento) {
                $this->form_validation->set_message('check_data_com_dia_vencimento', $this->lang->line('day_must_match_due_day'));
                return FALSE;
            } else {
                return true;
            }
        } else {
            $this->form_validation->set_message('check_data_com_dia_vencimento', $this->lang->line('required_field'));
            return FALSE;
        }
    }

    public function check_existe_mensalidade($mensalidade_data_vencimento) {
        $mensalidade_mensalista_id = $this->input->post('mensalidade_mensalista_hidden_id');
        $mensalidade_user = $this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalidade_mensalista_id, 'mensalidade_data_vencimento' => $mensalidade_data_vencimento));

        if ($mensalidade_user) {
            $mensalidade_data_vencimento_post = explode('-', $mensalidade_data_vencimento);
            $mensalidade_data_vencimento_user = explode('-', $mensalidade_user->mensalidade_data_vencimento);

            if ($mensalidade_data_vencimento_post[0] == $mensalidade_data_vencimento_user[0] && $mensalidade_data_vencimento_post[1] == $mensalidade_data_vencimento_user[1]) {
                $this->form_validation->set_message('check_existe_mensalidade', $this->lang->line('monthly_payment_exists_for_date'));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function check_data_valida($mensalidade_data_vencimento) {
        $data_atual = strtotime(date('Y-m-d'));
        $mensalidade_data_vencimento = strtotime($mensalidade_data_vencimento);

        if ($data_atual > $mensalidade_data_vencimento) {
            $this->form_validation->set_message('check_data_valida', $this->lang->line('due_date_must_be_current_or_future'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($mensalidade_id = NULL) {
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', $this->lang->line('no_permission_to_delete'));
            redirect('/');
        }

        if (!$mensalidade_id || !$this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id))) {
            $this->session->set_flashdata('error', $this->lang->line('monthly_payment_not_found'));
            redirect($this->router->fetch_class());
        }
        if ($this->core_model->get_by_id('mensalidades', array('mensalidade_id' => $mensalidade_id, 'mensalidade_status' => 0))) {
            $this->session->set_flashdata('error', $this->lang->line('open_monthly_payment_cannot_delete'));
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('mensalidades', array('mensalidade_id' => $mensalidade_id));
        redirect($this->router->fetch_class());
    }
}