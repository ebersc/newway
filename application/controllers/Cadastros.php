<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastros extends CI_Controller{

    public function __construct(){
        try{
            parent::__construct();
            $this->load->model("CadastrosFilmesSeries_model");
            $this->load->model("Login_model");
            $this->load->model("Token_model");
        }catch(Exception $e){
            throw $e;
        }
    }

    private function verificaLogin(){
        try{
            
            $token = $this->input->post('token');
            $valido = $this->Token_model->buscar(['id_usuario' => 0,'token' => $token, 'ativo' =>1]);

            if((!isset($this->session->user_id) || empty( $this->session->user_id)) && !$valido){
                return false;
            }
            return true;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function cadastrar(){
        try{
            if($this->verificaLogin()){
                $post = $this->input->post();

                $dados = [
                    'nome' => $post['nome'],
                    'tipo' => $post['tipo']
                ];

                $this->CadastrosFilmesSeries_model->inserir($dados);

                echo json_encode(["status" => 200, "msg" => "Dados inseridos com sucesso"]);
            }else{
                throw new Exception("Usuário não está logado");
            }
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro, " . $e->getMessage()]);
        }
    }

    public function listar(){
        try{
            if($this->verificaLogin()){
                
                $dados = $this->input->post();

                $where = [];

                if(isset($dados['nome'])){
                    $where['cfs.nome'] = $dados['nome'];
                }

                if(isset($dados['tipo'])){
                    $dados['tipo'] = strtolower($dados['tipo']);
                    $where['t.nome_tipo'] = $dados['tipo'];
                }

                $dados = $this->CadastrosFilmesSeries_model->buscar($where);
                $this->Token_model->atualizaExpiracaoToken();
                echo json_encode($dados);
            }else{
                throw new Exception("Usuário não está logado");
            }
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro, " . $e->getMessage()]);
        }
    }

    public function atualizar(){
        try{
            if($this->verificaLogin()){
                $post = $this->input->input_stream();

                $this->Token_model->atualizaExpiracaoToken();

                if(!isset($post['id']) || empty($post['id'])){
                    throw new Exception("ID não informado!");
                }

                $dados = [];

                if(isset($post['nome']) && !empty($post['nome'])){
                    $dados['nome'] = $post['nome'];
                }

                if(isset($post['tipo']) && !empty($post['tipo'])){
                    $dados['tipo'] = $post['tipo'];
                }

                $where  = array('id' => $post['id']);

                $this->CadastrosFilmesSeries_model->atualizar($dados, $where);

                echo json_encode(["status" => 200, "msg" => "Dados atualizados com sucesso"]);
            }else{
                throw new Exception("Usuário não está logado");
            }
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro, " . $e->getMessage()]);
        }
    }

    public function excluir(){
        try{
            if($this->verificaLogin()){
                $data = $this->input->input_stream();

                $this->Token_model->atualizaExpiracaoToken();

                if(!isset($data['id']) || empty($data['id'])){
                    throw new Exception("ID não informado!");
                }

                $where = array("id" => $data['id']);

                $this->CadastrosFilmesSeries_model->deletar($where);

                echo json_encode(["status" => 200, "msg" => "Dados atualizados com sucesso"]);
            }else{
                throw new Exception("Usuário não logado");
            }
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro, " . $e->getMessage()]);
        }
    }
}