<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastros extends CI_Controller{

    public function __construct(){
        try{
            parent::__construct();
            $this->load->model("CadastrosFilmesSeries_model");
        }catch(Exception $e){
            throw $e;
        }
    }

    public function cadastrar(){
        try{
            $post = $this->input->post();

            $dados = [
                'nome' => $post['nome'],
                'tipo' => $post['tipo']
            ];

            $this->CadastrosFilmesSeries_model->inserir($dados);

            echo json_encode(["status" => 200, "msg" => "Dados inseridos com sucesso"]);
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro ao cadastrar!"]);
        }
    }

    public function listar(){
        try{
            $dados = $this->CadastrosFilmesSeries_model->buscar();
            echo json_encode($dados);
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro ao buscar os dados!"]);
        }
    }

    public function atualizar(){
        try{
            $post = $this->input->input_stream();

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
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro ao cadastrar!"]);
        }
    }

    public function excluir(){
        try{
            $data = $this->input->input_stream();

            if(!isset($data['id']) || empty($data['id'])){
                throw new Exception("ID não informado!");
            }

            $where = array("id" => $data['id']);

            $this->CadastrosFilmesSeries_model->deletar($where);

            echo json_encode(["status" => 200, "msg" => "Dados atualizados com sucesso"]);
        }catch(Exception $e){
            echo json_encode(["status"=>500, "msg" => "Erro ao excluir " . $e->getMessage()]);
        }
    }

    public function index()
	{
		// $this->load->view('welcome_message');
		echo 'ola mundo';
	}
}