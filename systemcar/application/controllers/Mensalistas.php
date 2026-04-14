<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Mensalistas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
        $this->lang->load('mensalistas', 'english');
    }

    public function index() {
        $data = array(
            'titulo' => $this->lang->line('registered_monthly_clients'),
            'sub_titulo' => $this->lang->line('listing_registered_monthly_clients'),
            'icone_view' => 'fas fa-users',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'mensalistas' => $this->core_model->get_all('mensalistas'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('mensalistas/index');
        $this->load->view('layout/footer');
    }

    public function core($mensalista_id = NULL) {

        if (!$mensalista_id) {
            // Creating
            $this->form_validation->set_rules('mensalista_nome', $this->lang->line('name'), 'trim|required|min_length[2]|max_length[20]');
            $this->form_validation->set_rules('mensalista_sobrenome', $this->lang->line('surname'), 'trim|required|min_length[2]|max_length[100]');
            $this->form_validation->set_rules('mensalista_data_nascimento', $this->lang->line('birth_date'), 'required');
            $this->form_validation->set_rules('mensalista_id_passport', 'ID/Passport', 'trim|required|max_length[50]');
            $this->form_validation->set_rules('mensalista_email', $this->lang->line('email'), 'trim|required|valid_email|max_length[80]|is_unique[mensalistas.mensalista_email]');
            $this->form_validation->set_rules('mensalista_telefone_movel', $this->lang->line('mobile_phone'), 'trim|required|min_length[14]|max_length[15]|is_unique[mensalistas.mensalista_telefone_movel]');
            $this->form_validation->set_rules('mensalista_endereco', $this->lang->line('address'), 'trim|required|min_length[10]|max_length[155]');
            $this->form_validation->set_rules('mensalista_numero_endereco', $this->lang->line('address_number'), 'trim|required|max_length[20]');
            $this->form_validation->set_rules('mensalista_cidade', $this->lang->line('city'), 'trim|required|min_length[4]|max_length[80]');
            $this->form_validation->set_rules('mensalista_estado', $this->lang->line('state'), 'trim|required|exact_length[2]');
            $this->form_validation->set_rules('mensalista_dia_vencimento', $this->lang->line('due_day'), 'trim|required|integer|greater_than[0]|less_than[32]');
            $this->form_validation->set_rules('mensalista_observacao', $this->lang->line('observation'), 'trim|max_length[200]');

            if ($this->form_validation->run()) {

                $data = elements (
                    array(
                        'mensalista_nome',
                        'mensalista_sobrenome',
                        'mensalista_data_nascimento',
                        'mensalista_id_passport',
                        'mensalista_email',
                        'mensalista_telefone_movel',
                        'mensalista_endereco',
                        'mensalista_numero_endereco',
                        'mensalista_cidade',
                        'mensalista_estado',
                        'mensalista_ativo',
                        'mensalista_dia_vencimento',
                        'mensalista_observacao',
                    ), $this->input->post() 
                );

                $data['mensalista_estado'] = strtoupper($this->input->post('mensalista_estado'));
                $data = html_escape($data);

                $this->core_model->insert('mensalistas', $data);
                redirect($this->router->fetch_class());
            } else {
                // Validation error
                $data = array(
                    'titulo' => $this->lang->line('register_monthly_client'),
                    'sub_titulo' => $this->lang->line('registering_monthly_client'),
                    'icone_view' => 'fas fa-users',
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js'
                    ),
                    'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
                );
                $this->load->view('layout/header', $data);
                $this->load->view('mensalistas/core');
                $this->load->view('layout/footer');
            }
        } else {
            if (!$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {
                $this->session->set_flashdata('error', $this->lang->line('monthly_client_not_found'));
                redirect($this->router->fetch_class());
            } else {
                $this->form_validation->set_rules('mensalista_nome', $this->lang->line('name'), 'trim|required|min_length[2]|max_length[20]');
                $this->form_validation->set_rules('mensalista_sobrenome', $this->lang->line('surname'), 'trim|required|min_length[2]|max_length[100]');
                $this->form_validation->set_rules('mensalista_data_nascimento', $this->lang->line('birth_date'), 'required');
                $this->form_validation->set_rules('mensalista_id_passport', 'ID/Passport', 'trim|required|max_length[50]');
                $this->form_validation->set_rules('mensalista_email', $this->lang->line('email'), 'trim|required|valid_email|max_length[80]|callback_check_email');
                $this->form_validation->set_rules('mensalista_telefone_movel', $this->lang->line('mobile_phone'), 'trim|required|min_length[14]|max_length[15]|callback_check_telefone_movel');
                $this->form_validation->set_rules('mensalista_endereco', $this->lang->line('address'), 'trim|required|min_length[10]|max_length[155]');
                $this->form_validation->set_rules('mensalista_numero_endereco', $this->lang->line('address_number'), 'trim|required|max_length[20]');
                $this->form_validation->set_rules('mensalista_cidade', $this->lang->line('city'), 'trim|required|min_length[4]|max_length[80]');
                $this->form_validation->set_rules('mensalista_estado', $this->lang->line('state'), 'trim|required|exact_length[2]');
                $this->form_validation->set_rules('mensalista_dia_vencimento', $this->lang->line('due_day'), 'trim|required|integer|greater_than[0]|less_than[32]');
                $this->form_validation->set_rules('mensalista_observacao', $this->lang->line('observation'), 'trim|max_length[200]');

                if ($this->form_validation->run()) {
                    $mensalista_ativo = $this->input->post('mensalista_ativo');
                    if ($mensalista_ativo == 0) {
                        if ($this->db->table_exists('mensalidades')) {
                            if ($this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalista_id, 'mensalidade_status' => 0))) {
                                $this->session->set_flashdata('error', $this->lang->line('cannot_deactivate_client_with_open_payments'));
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    $data = elements (
                        array(
                            'mensalista_nome',
                            'mensalista_sobrenome',
                            'mensalista_data_nascimento',
                            'mensalista_id_passport',
                            'mensalista_email',
                            'mensalista_telefone_movel',
                            'mensalista_endereco',
                            'mensalista_numero_endereco',
                            'mensalista_cidade',
                            'mensalista_estado',
                            'mensalista_ativo',
                            'mensalista_dia_vencimento',
                            'mensalista_observacao',
                        ), $this->input->post() 
                    );
                    $data['mensalista_estado'] = strtoupper($this->input->post('mensalista_estado'));
                    $this->core_model->update('mensalistas', $data, array('mensalista_id' => $mensalista_id));
                    redirect($this->router->fetch_class());
                } else {
                    // Validation error
                    $data = array(
                        'titulo' => $this->lang->line('edit_monthly_client'),
                        'sub_titulo' => $this->lang->line('editing_monthly_client'),
                        'icone_view' => 'fas fa-users',
                        'scripts' => array(
                            'plugins/mask/jquery.mask.min.js',
                            'plugins/mask/custom.js',
                        ),
                        'mensalista' => $this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id)),
                    );
                    $this->load->view('layout/header', $data);
                    $this->load->view('mensalistas/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    // Métodos de validación antiguos para CPF, RG, teléfono fijo, etc. pueden ser eliminados si ya no usas esos campos.
    // Solo dejo los de email y teléfono móvil, que sí usas.

    public function check_email($mensalista_email) {
        $mensalista_id = $this->input->post('mensalista_id');
        if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_email' => $mensalista_email))) {
            $this->form_validation->set_message('check_email', $this->lang->line('field_already_exists'));
            return FALSE;
        } else {
            return TRUE; 
        }
    }

    public function check_telefone_movel($mensalista_telefone_movel) {
        $mensalista_id = $this->input->post('mensalista_id');
        if ($this->core_model->get_by_id('mensalistas', array('mensalista_id !=' => $mensalista_id, 'mensalista_telefone_movel' => $mensalista_telefone_movel))) {
            $this->form_validation->set_message('check_telefone_movel', $this->lang->line('field_already_exists'));
            return FALSE;
        } else {
            return TRUE; 
        }
    }

    public function del($mensalista_id = NULL) {
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', $this->lang->line('no_permission_to_delete'));
            redirect('/');
        }
        if (!$mensalista_id || !$this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id))) {
            $this->session->set_flashdata('error', $this->lang->line('monthly_client_not_found'));
            redirect($this->router->fetch_class());
        }
        if ($this->core_model->get_by_id('mensalistas', array('mensalista_id' => $mensalista_id, 'mensalista_ativo' => 1))) {
            $this->session->set_flashdata('error', $this->lang->line('cannot_delete_active_client'));
            redirect($this->router->fetch_class());
        }
        if ($this->core_model->get_by_id('mensalidades', array('mensalidade_mensalista_id' => $mensalista_id))) {
            $this->session->set_flashdata('error', $this->lang->line('cannot_delete_client_with_payments'));
            redirect($this->router->fetch_class());
        }
        $this->core_model->delete('mensalistas', array('mensalista_id' => $mensalista_id));
        redirect($this->router->fetch_class());
    }
}