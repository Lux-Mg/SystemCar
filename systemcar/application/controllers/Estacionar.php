<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Estacionar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }

        $this->load->model('estacionar_model');
        $this->lang->load('estacionar', 'english');
    }

    public function index() {
        $data = array(
            'titulo' => $this->lang->line('parking_tickets'),
            'sub_titulo' => $this->lang->line('listing_tickets'),
            'icone_view' => 'fas fa-parking',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
                'dist/css/estacionar.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'estacionados' => $this->estacionar_model->get_all(),
            'numero_vagas_pequeno' => $this->estacionar_model->get_numero_vagas(1),
            'vagas_ocupadas_pequeno' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 1)),
            'numero_vagas_medio' => $this->estacionar_model->get_numero_vagas(2),
            'vagas_ocupadas_medio' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 2)),
            'numero_vagas_grande' => $this->estacionar_model->get_numero_vagas(4),
            'vagas_ocupadas_grande' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 4)),
            'numero_vagas_moto' => $this->estacionar_model->get_numero_vagas(5),
            'vagas_ocupadas_moto' => $this->core_model->get_all('estacionar', array('estacionar_status' => 0, 'estacionar_precificacao_id' => 5)),
        );
         
        $this->load->view('layout/header', $data);
        $this->load->view('estacionar/index');
        $this->load->view('layout/footer');
    }

    public function core($estacionar_id = NULL) {

        if (!$estacionar_id) {
            // Register

            $this->form_validation->set_rules('estacionar_precificacao_id', $this->lang->line('category'), 'required');
            $this->form_validation->set_rules('estacionar_numero_vaga', $this->lang->line('spot'), 'required|integer|greater_than[0]|callback_check_vaga_ocupada|callback_check_range_vagas_categoria');
            $this->form_validation->set_rules('estacionar_placa_veiculo', $this->lang->line('vehicle_plate'), 'required|exact_length[8]|callback_check_placa_status_aberta');
            $this->form_validation->set_rules('estacionar_marca_veiculo', $this->lang->line('vehicle_brand'), 'required|min_length[2]|max_length[30]');
            $this->form_validation->set_rules('estacionar_modelo_veiculo', $this->lang->line('vehicle_model'), 'required|min_length[2]|max_length[20]');
           
            if ($this->form_validation->run()) {

                $data = elements (
                    array(
                        'estacionar_valor_hora',
                        'estacionar_numero_vaga',
                        'estacionar_placa_veiculo',
                        'estacionar_marca_veiculo',
                        'estacionar_modelo_veiculo',
                    ), $this->input->post() 
                );

                $data['estacionar_precificacao_id'] = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));
                $data['estacionar_status'] = 0;

                $data = html_escape($data);

                $this->core_model->insert('estacionar', $data, TRUE);

                $estacionar_id = $this->session->userdata('last_id');

                redirect($this->router->fetch_class() . '/acoes/' . $estacionar_id);

            } else {
                $data = array(
                    'titulo' => $this->lang->line('register_ticket'),
                    'sub_titulo' => $this->lang->line('registering_tickets'),
                    'icone_view' => 'fas fa-parking',
                    'texto_modal' => $this->lang->line('are_you_sure_save'),
                    'scripts' => array(
                        'plugins/mask/jquery.mask.min.js',
                        'plugins/mask/custom.js',
                        'js/estacionar/estacionar.js',
                    ),
                    'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                );
                $this->load->view('layout/header', $data);
                $this->load->view('estacionar/core');
                $this->load->view('layout/footer');
            }

        } else {

            if (!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
                $this->session->set_flashdata('error', $this->lang->line('ticket_not_found'));
                redirect($this->router->fetch_class());
            } else {
                // Ticket closing
                $estacionar_tempo_decorrido = str_replace('.','', $this->input->post('estacionar_tempo_decorrido'));

                if ($estacionar_tempo_decorrido > '015') {
                    $this->form_validation->set_rules('estacionar_forma_pagamento_id', $this->lang->line('payment_method'), 'required');
                } else {
                    $this->form_validation->set_rules('estacionar_forma_pagamento_id', $this->lang->line('payment_method'), 'trim');
                }
                
                if ($this->form_validation->run()) {

                    $data = elements (
                        array(
                            'estacionar_valor_devido',
                            'estacionar_forma_pagamento_id',
                            'estacionar_tempo_decorrido',
                        ), $this->input->post() 
                    );

                    // Remove any currency symbol from the value before saving
                    $data['estacionar_valor_devido'] = preg_replace('/[^0-9.,]/', '', $data['estacionar_valor_devido']);

                    if ($estacionar_tempo_decorrido <= '015') {
                        $data['estacionar_forma_pagamento_id'] = 6; // free payment method
                    }

                    $data['estacionar_data_saida'] = date('Y-m-d H:i:s');
                    $data['estacionar_status'] = 1;

                    $data = html_escape($data);

                    $this->core_model->update('estacionar', $data, array('estacionar_id' => $estacionar_id));

                    redirect($this->router->fetch_class() . '/acoes/' . $estacionar_id);

                } else {
                    $data = array(
                        'titulo' => $this->lang->line('closing_ticket'),
                        'sub_titulo' => $this->lang->line('listing_tickets_to_close'),
                        'icone_view' => 'fas fa-parking',
                        'texto_modal' => $this->lang->line('are_you_sure_close'),
                        'scripts' => array(
                            'plugins/mask/jquery.mask.min.js',
                            'plugins/mask/custom.js',
                            'js/estacionar/estacionar.js',
                        ),
                        'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
                        'precificacoes' => $this->core_model->get_all('precificacoes', array('precificacao_ativa' => 1)),
                        'formas_pagamentos' => $this->core_model->get_all('formas_pagamentos', array('forma_pagamento_ativa' => 1)),
                    );
                    $this->load->view('layout/header', $data);
                    $this->load->view('estacionar/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function check_range_vagas_categoria($numero_vaga) {
        $precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));
        if ($precificacao_id) {
            $precificacao = $this->core_model->get_by_id('precificacoes', array('precificacao_id' => $precificacao_id));
            if ($precificacao->precificacao_numero_vagas < $numero_vaga) {
                $this->form_validation->set_message('check_range_vagas_categoria', sprintf($this->lang->line('spot_number_range'), $precificacao->precificacao_numero_vagas));
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('check_range_vagas_categoria', $this->lang->line('choose_category'));
            return FALSE;
        }
    }

    public function check_vaga_ocupada($estacionar_numero_vaga) {
        $estacionar_precificacao_id = intval(substr($this->input->post('estacionar_precificacao_id'), 0, 1));
        if ($this->core_model->get_by_id('estacionar', array('estacionar_numero_vaga' => $estacionar_numero_vaga, 'estacionar_status' => 0, 'estacionar_precificacao_id' => $estacionar_precificacao_id))) {
            $this->form_validation->set_message('check_vaga_ocupada', $this->lang->line('spot_already_taken'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function check_placa_status_aberta($estacionar_placa_veiculo) {
        $estacionar_placa_veiculo = strtoupper($estacionar_placa_veiculo);
        if ($this->core_model->get_by_id('estacionar', array('estacionar_placa_veiculo' => $estacionar_placa_veiculo, 'estacionar_status' => 0))) {
            $this->form_validation->set_message('check_placa_status_aberta', $this->lang->line('open_ticket_for_plate'));
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function acoes($estacionar_id = NULL) {
        if (!$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
            $this->session->set_flashdata('error', $this->lang->line('ticket_not_found'));
            redirect($this->router->fetch_class());
        } else {
            $data = array(
                'titulo' => $this->lang->line('what_do_you_want'),
                'sub_titulo' => $this->lang->line('choose_option'),
                'icone_view' => 'fas fa-question',
                'estacionado' => $this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id)),
            );
            $this->load->view('layout/header', $data);
            $this->load->view('estacionar/acoes');
            $this->load->view('layout/footer');
        }
    }

    public function pdf($estacionar_id = NULL) {
        if (!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
            $this->session->set_flashdata('error', $this->lang->line('ticket_not_found_print'));
            redirect($this->router->fetch_class());
        } else {

            $this->load->library('Pdf');
            $this->load->model('estacionar_model');

            $empresa = $this->core_model->get_by_id('sistema', array('sistema_id' => 1));
            $ticket = $this->estacionar_model->get_by_id($estacionar_id);
            $currency = $this->config->item('currency_symbol');

            $file_name = 'Ticket - Plate_' . $ticket->estacionar_placa_veiculo;

            $html = '<html style="font-size:10px">';
            $html .= '<head>';
            $html .= '<meta charset="utf-8">';
            $html .= '<title>'.$empresa->sistema_razao_social.'</title>';
            $html .= '</head>';
            $html .= '<body>';

            $html .= '<h5 align="center" style="font-size:12px">'
                . $empresa->sistema_nome_fantasia . '<br/>'
                . $empresa->sistema_endereco . ' - ' . $empresa->sistema_numero . '<br/>'
                . $empresa->sistema_telefone_movel . '<br/>'
                . '</h5>';

            $html .= '<hr>';

            $dados_saida = '';

            if ($ticket->estacionar_status == 1) {
                // Only add currency symbol here, value comes without symbol
                $dados_saida .= '<strong>' . $this->lang->line('exit_date') . ':&nbsp;</strong>' . formata_data_banco_com_hora($ticket->estacionar_data_saida) . '<br/>'
                    . '<strong>' . $this->lang->line('elapsed_time') . ':&nbsp;</strong>' . $ticket->estacionar_tempo_decorrido . '<br/>'
                    . '<strong>' . $this->lang->line('amount_paid') . ':</strong> ' . $currency . '&nbsp;' . $ticket->estacionar_valor_devido . '<br/>'
                    . '<strong>' . $this->lang->line('payment_method') . ':&nbsp;</strong>' . $ticket->forma_pagamento_nome . '<br/>';
            }

            $html .= '<p align="right">' . $this->lang->line('ticket_number') . ':' . $ticket->estacionar_id . '</p><br/>';

            $html .= '<p>'
                . '<strong>' . $this->lang->line('vehicle_plate') . ':&nbsp;</strong>' . $ticket->estacionar_placa_veiculo . '<br/>'
                . '<strong>' . $this->lang->line('vehicle_brand') . ':&nbsp;</strong>' . $ticket->estacionar_marca_veiculo . '<br/>'
                . '<strong>' . $this->lang->line('vehicle_model') . ':&nbsp;</strong>' . $ticket->estacionar_modelo_veiculo . '<br/>'
                . '<strong>' . $this->lang->line('vehicle_category') . ':&nbsp;</strong>' . $ticket->precificacao_categoria . '<br/>'
                . '<strong>' . $this->lang->line('spot_number') . ':&nbsp;</strong>' . $ticket->estacionar_numero_vaga . '<br/>'
                . '<strong>' . $this->lang->line('entry_date') . ':&nbsp;</strong>' . formata_data_banco_com_hora($ticket->estacionar_data_entrada) . '<br/>'
                . '<strong>' . $this->lang->line('exit_date') . ':&nbsp;</strong>'
                . $dados_saida
                . '</p>';

            $html .= '<br>';
            $html .= '<hr>';

            $html .= '<h5 align="center" style="font-size:12px">'
                . $empresa->sistema_razao_social . '<br/>'
                . $empresa->sistema_texto_ticket . '<br/>'
                . date('d/m/Y H:i:s') . '<br/>'
                . '</h5>';

            $html .= '</body>';
            $html .= '</html>';

            $this->pdf->createPDF($html, $file_name, false);
        }
    }

    public function del($estacionar_id = NULL) {
        if (!$estacionar_id || !$this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id))) {
            $this->session->set_flashdata('error', $this->lang->line('ticket_not_found'));
            redirect($this->router->fetch_class());
        }
        if ($this->core_model->get_by_id('estacionar', array('estacionar_id' => $estacionar_id, 'estacionar_status' => 0))) {
            $this->session->set_flashdata('error', $this->lang->line('ticket_cannot_delete'));
            redirect($this->router->fetch_class());
        }
        $this->core_model->delete('estacionar', array('estacionar_id' => $estacionar_id));
        redirect($this->router->fetch_class());
    }
}