<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller{
    public function __construct(){
       parent::__construct();
       $this->load->model('Login_model');
       $this->load->model('Token_model');
    }

    public function entrar(){
        try{
            $post = $this->input->post();

            if(isset($post['email']) && isset($post['senha'])){
                $resp = $this->Login_model->login($post['email'], $post['senha']);

                echo json_encode($resp);
            }else{
                echo json_encode(['status' => http_response_code(401), 'msg' => "Acesso não autorizado!"]);
            }
        }catch(Exception $e){
            throw $e;
        }
    }

    public function sair(){
        try{
            $id = $this->input->post('id_usuario');
            if($this->session->user_id == $id){
                unset($this->session->user_email);
                unset($this->session->user_id);
                $this->Token_model->inativa_tokens('id_usuario = ' . $id);
                echo json_encode(['status' => 200, 'msg' => "Sessão encerrada com sucesso"]);
            }
        }catch(Exception $e){
            throw $e;
        }
    }
}