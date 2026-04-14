<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Precificacoes extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
        $this->lang->load('precificacoes', 'english');
    }

    public function index() {
        $data = array(
            'titulo' => $this->lang->line('registered_pricings'),
            'sub_titulo' => $this->lang->line('listing_registered_pricings'),
            'icone_view' => 'fas fa-dollar-sign',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'precificacoes' => $this->core_model->get_all('precificacoes'),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('precificacoes/index');
        $this->load->view('layout/footer');
    }

    public function core($precificacao_id = NULL) {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', $this->lang->line('no_permission_to_edit'));
            redirect($this->router->fetch_class());
        }

        if (!$precificacao_id) {
            // Creating

            $this->form_validation->set_rules('precificacao_categoria', $this->lang->line('category'), 'trim|required|min_length[4]|max_length[40]|is_unique[precificacoes.precificacao_categoria]');
            $this->form_validation->set_rules('precificacao_valor_hora', $this->lang->line('hour_value'), 'trim|required|max_length[40]');
            $this->form_validation->set_rules('precificacao_valor_mensalidade', $this->lang->line('monthly_value'), 'trim|required|max_length[40]');
            $this->form_validation->set_rules('precificacao_numero_vagas', $this->lang->line('number_of_spots'), 'trim|required|integer|greater_than[0]');

            if ($this->form_validation->run()) {

                $data = elements(
                    array(
                        'precificacao_categoria',
                        'precificacao_valor_hora',
                        'precificacao_valor_mensalidade',
                        'precificacao_numero_vagas',
                        'precificacao_ativa',
                    ), $this->input->post()
                );

                $data = html_escape($data);

                $this->core_model->insert('precificacoes', $data);
                redirect($this->router->fetch_class());

            } else {
                // Validation error
                $data = array(
                    'titulo' => $this->lang->line('register_pricing'),
                    'sub_titulo' => $this->lang->line('registering_pricing'),
                    'icone_view' => 'fas fa-dollar-sign',
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js'
                    ),
                );
                $this->load->view('layout/header', $data);
                $this->load->view('precificacoes/core');
                $this->load->view('layout/footer');
            }

        } else {
            // Updating
            if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {
                $this->session->set_flashdata('error', $this->lang->line('pricing_not_found'));
                redirect($this->router->fetch_class());
            } else {

                $this->form_validation->set_rules('precificacao_categoria', $this->lang->line('category'), 'trim|required|min_length[4]|max_length[40]|callback_categoria_check');
                $this->form_validation->set_rules('precificacao_valor_hora', $this->lang->line('hour_value'), 'trim|required|max_length[40]');
                $this->form_validation->set_rules('precificacao_valor_mensalidade', $this->lang->line('monthly_value'), 'trim|required|max_length[40]');
                $this->form_validation->set_rules('precificacao_numero_vagas', $this->lang->line('number_of_spots'), 'trim|required|integer|greater_than[0]');

                if ($this->form_validation->run()) {

                    $precificacao_ativa = $this->input->post('precificacao_ativa');
                    if ($precificacao_ativa == 0) {
                        if ($this->db->table_exists('estacionar')) {
                            if ($this->core_model->get_by_id('estacionar', array('estacionar_precificacao_id' => $precificacao_id, 'estacionar_status' => 0))) {
                                $this->session->set_flashdata('error', $this->lang->line('category_in_use_parking'));
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    if ($precificacao_ativa == 0) {
                        if ($this->db->table_exists('mensalidades')) {
                            if ($this->core_model->get_by_id('mensalidades', array('mensalidade_precificacao_id' => $precificacao_id, 'mensalidade_status' => 0))) {
                                $this->session->set_flashdata('error', $this->lang->line('category_in_use_monthly'));
                                redirect($this->router->fetch_class());
                            }
                        }
                    }

                    $data = elements(
                        array(
                            'precificacao_categoria',
                            'precificacao_valor_hora',
                            'precificacao_valor_mensalidade',
                            'precificacao_numero_vagas',
                            'precificacao_ativa',
                        ), $this->input->post()
                    );

                    $data = html_escape($data);

                    $this->core_model->update('precificacoes', $data, array('precificacao_id' => $precificacao_id));
                    redirect($this->router->fetch_class());

                } else {
                    // Validation error
                    $data = array(
                        'titulo' => $this->lang->line('edit_pricing'),
                        'sub_titulo' => $this->lang->line('editing_pricing'),
                        'icone_view' => 'fas fa-dollar-sign',
                        'scripts' => array(
                            'plugins/mask/jquery.mask.min.js',
                            'plugins/mask/custom.js'
                        ),
                        'precificacao' => $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id)),
                    );
                    $this->load->view('layout/header', $data);
                    $this->load->view('precificacoes/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function categoria_check($precificacao_categoria) {
        $precificacao_id = $this->input->post('precificacao_id');
        if ($this->core_model->get_by_id('precificacoes', array('precificacao_categoria' => $precificacao_categoria, 'precificacao_id !=' => $precificacao_id))) {
            $this->form_validation->set_message('categoria_check', $this->lang->line('category_already_exists'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($precificacao_id = NULL) {
        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', $this->lang->line('no_permission_to_delete'));
            redirect($this->router->fetch_class());
        }

        if (!$this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id))) {
            $this->session->set_flashdata('error', $this->lang->line('pricing_not_found'));
            redirect($this->router->fetch_class());
        }
        if ($this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id, 'precificacao_ativa' => 1))) {
            $this->session->set_flashdata('error', $this->lang->line('active_pricing_cannot_delete'));
            redirect($this->router->fetch_class());
        }

        $this->core_model->delete('precificacoes', array('precificacao_id' => $precificacao_id));
        redirect($this->router->fetch_class());
    }
}