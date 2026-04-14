<?php
/**
 * Author: Luis Mendoza
 * https://github.com/Lux-Mg
 */
defined('BASEPATH') OR exit('Action not allowed');

class Usuarios extends CI_Controller {

    public function __construct () {
        parent::__construct ();

        if (!$this->ion_auth->logged_in()) {
            redirect('login');
        }
    }

    public function index() {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('info', 'You do not have permission to access the USERS menu, only Admin!');
            redirect('/');
        }

        $data = array(
            'titulo' => 'Registered users',
            'sub_titulo' => 'Listing all registered users',
            'styles' => array(
                'plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css',
            ),
            'scripts' => array(
                'plugins/datatables.net/js/jquery.dataTables.min.js',
                'plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js',
                'plugins/datatables.net/js/estacionamento.js',
            ),
            'usuarios' => $this->ion_auth->users()->result(),
        );

        $this->load->view('layout/header', $data);
        $this->load->view('usuarios/index');
        $this->load->view('layout/footer');
    }

    public function core($usuario_id = NULL) {

        if (!$usuario_id) {

            // Register new user

            if (!$this->ion_auth->is_admin()) {
                $this->session->set_flashdata('info', 'You do not have permission to access this menu!');
                redirect('/');
            }

            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[50]');
            $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[20]|is_unique[users.username]');
            $this->form_validation->set_rules('email', 'E-mail', 'valid_email|trim|required|min_length[5]|max_length[130]|is_unique[users.email]');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
            $this->form_validation->set_rules('confirmacao', 'Confirmation', 'trim|required|matches[password]');
        
            if ($this->form_validation->run()) {

                $username = html_escape($this->input->post('username'));
                $password = html_escape($this->input->post('password'));
                $email = html_escape($this->input->post('email'));
                
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'active' => $this->input->post('active'),
                );
                $group = array($this->input->post('perfil')); 

                $additional_data = html_escape($additional_data);
            
                if ($this->ion_auth->register($username, $password, $email, $additional_data, $group)) {
                    $this->session->set_flashdata('sucesso', 'Data saved successfully!');
                } else {
                    $this->session->set_flashdata('error', 'Could not save the data!');
                }

                redirect($this->router->fetch_class());

            } else {
                // validation error
                $data = array(
                    'titulo' => 'Register user',
                    'sub_titulo' => 'Time to register users',
                    'icone_view' => 'ik ik-user',
                );
        
                $this->load->view('layout/header', $data);
                $this->load->view('usuarios/core');
                $this->load->view('layout/footer');
            }

        } else {

            // Edit user
            if (!$this->ion_auth->user($usuario_id)->row()) {
                exit('User does not exist');
            } else {
                // Edit user

                if ($this->session->userdata('user_id') != $usuario_id && !$this->ion_auth->is_admin()) {
                    $this->session->set_flashdata('error', 'Attention! You cannot edit a user different from your own!');
                    redirect('/');
                }

                $perfil_atual = $this->ion_auth->get_users_groups($usuario_id)->row();

                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|min_length[2]|max_length[50]');
                $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|min_length[2]|max_length[50]');
                $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[2]|max_length[20]|callback_username_check');
                $this->form_validation->set_rules('email', 'E-mail', 'valid_email|trim|required|min_length[5]|max_length[130]|callback_email_check');
                $this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]');
                $this->form_validation->set_rules('confirmacao', 'Confirmation', 'trim|matches[password]');

                if ($this->form_validation->run()) {

                    $data = elements (
                        array(
                            'first_name',
                            'last_name',
                            'username',
                            'email',
                            'password',
                            'active',
                        ), $this->input->post() 
                    );

                    if (!$this->ion_auth->is_admin()) {
                        unset($data['active']);
                    }

                    $password = $this->input->post('password');
                    // if password not provided, do not update
                    if (!$password) {
                        unset($data['password']);
                    }

                    $data = html_escape($data);

                    if ($this->ion_auth->update($usuario_id, $data)) {

                        $perfil_post = $this->input->post('perfil');

                        // if profile was provided, then it's admin
                        if ($perfil_post) {
                            if ($perfil_atual->id != $perfil_post) {
                                $this->ion_auth->remove_from_group($perfil_atual->id, $usuario_id);
                                $this->ion_auth->add_to_group($perfil_post, $usuario_id);
                            }
                        }

                        $this->session->set_flashdata('sucesso', 'Data updated successfully!');
                        
                    } else {
                        $this->session->set_flashdata('error', 'Could not update the data!');
                    }

                    if (!$this->ion_auth->is_admin()) {
                        redirect('/');
                    } else {
                        redirect('usuarios');
                    }

                } else {
                    // validation error
                    $data = array(
                        'titulo' => 'Edit user',
                        'sub_titulo' => 'Editing users',
                        'icone_view' => 'ik ik-user',
                        'usuario' => $this->ion_auth->user($usuario_id)->row(),
                        'perfil_usuario' => $this->ion_auth->get_users_groups($usuario_id)->row(),
                    );
            
                    $this->load->view('layout/header', $data);
                    $this->load->view('usuarios/core');
                    $this->load->view('layout/footer');
                }
            }
        }
    }

    public function username_check($username = NULL) {
        $usuario_id = $this->input->post('usuario_id');

        if ($this->core_model->get_by_id('users', array('username' => $username, 'id !=' => $usuario_id))) {
            $this->form_validation->set_message('username_check', 'This username already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function email_check($email = NULL) {
        $usuario_id = $this->input->post('usuario_id');

        if ($this->core_model->get_by_id('users', array('email' => $email, 'id !=' => $usuario_id))) {
            $this->form_validation->set_message('email_check', 'This e-mail already exists');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function del($usuario_id = NULL) {

        if (!$this->ion_auth->is_admin()) {
            $this->session->set_flashdata('error', 'Attention! You do not have permission to delete a user!');
            redirect('/');
        }

        if (!$usuario_id || !$this->core_model->get_by_id('users', array('id' => $usuario_id))) {
            $this->session->set_flashdata('error', 'User not found!');
            redirect($this->router->fetch_class());
        } else {

            if ($this->ion_auth->is_admin($usuario_id)) {
                $this->session->set_flashdata('error', 'Administrator cannot be deleted!');
                redirect($this->router->fetch_class());
            }

            if ($this->ion_auth->delete_user($usuario_id)) {
                $this->session->set_flashdata('sucesso', 'Record deleted successfully!');
            } else {
                $this->session->set_flashdata('error', 'Could not delete the record!');
            }

            redirect($this->router->fetch_class());
        }
    }
}