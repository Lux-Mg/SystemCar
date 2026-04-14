<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Ação não permitida');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cargar el archivo de idioma de Ion Auth en inglés
        $this->lang->load('ion_auth', 'english');
    }

    public function index() {
        $data = array(
            'titulo' => 'Login'
        );

        $this->load->view('layout/header', $data);
        $this->load->view('login/index');
        $this->load->view('layout/footer');
    }

    public function auth() {
        $identity = html_escape($this->input->post('email'));
        $password = html_escape($this->input->post('password'));
        $remember = FALSE; // remember the user
        
        if ($this->ion_auth->login($identity, $password, $remember)) {
            $usuario = $this->core_model->get_by_id('users', array('email' => $identity));

            $this->session->set_flashdata('success', sprintf($this->lang->line('welcome_user'), $usuario->first_name));
            redirect('/');
        } else {
            // Usando la función de idioma para mostrar el error en inglés
            $this->session->set_flashdata('error', '<i class="fas fa-exclamation-triangle"></i>&nbsp;' . $this->lang->line('login_failed'));
            redirect($this->router->fetch_class());
        }
    }

    public function logout() {
        $this->ion_auth->logout();
        redirect($this->router->fetch_class());
    }

}
