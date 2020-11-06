<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ServicoController
 *
 * @author Administrator
 */
class ServicoController extends Controller {

    public function init() {
        $this->auth = new AuthHelper();
        $this->auth->setLoginControllerAction('Login', 'index')->checkLogin('redirect');

        $this->session = new SessionHelper();
        $this->dados['userInfo'] = $this->session->selectSession('userData');

        $this->dados['title_page'] = "Serviço | Help Desk";
        $this->dados['page_context'] = "Serviço";
        $this->dados['page_icon'] = "fa fa-shield";
        $this->dados['page_url'] = '/autenticador/servico/';
        $this->dados['home_url'] = '/autenticador/home/';
    }

    public function indexAction() {
        try {
            $servicoDAO = new ServicoDAO();
            $this->dados['entities'] = $servicoDAO->listarTodos();
            $this->dados['areas'] = (new AreaDAO())->listarTodas();
            $this->view('servico/index', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function registarAction() {
        try {
            $servico = new Servico();

            $servico->setArea((new AreaDAO())->buscarID(filter_input(INPUT_POST, 'area')));
            $servico->setNome(filter_input(INPUT_POST, 'nome'));
            $servico->setDescricao(filter_input(INPUT_POST, 'descricao'));

            $servicoDAO = new ServicoDAO();
            $servicoDAO->salvar($servico);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('servico', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function verAction() {
        try {
            $servicoDAO = new ServicoDAO();
            $retorno = $servicoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            if ($this->dados['entity'] == null) {
                throw new \Exception("Entidade não encontrada.");
            }
            $this->dados['empresas'] = (new EmpresaDAO())->listarTodas();
            $this->view('servico/ver', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function editarAction() {
        try {
            $servicoDAO = new ServicoDAO();
            $retorno = $servicoDAO->buscarID($this->getParams('id'));
            $this->dados['entity'] = ($retorno != null ? $retorno : null);
            if ($this->dados['entity'] == null) {
                throw new \Exception("Serviço não encontrada.");
            }
            $this->dados['empresas'] = (new EmpresaDAO())->listarTodas();
            $this->view('servico/editar', $this->dados);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function actualizarAction() {
        try {
            $servicoDAO = new ServicoDAO();
            $retorno = $servicoDAO->buscarID(filter_input(INPUT_POST, 'id_servico'));

            $servico = $retorno;

            $servico->setArea((new AreaDAO())->buscarID(filter_input(INPUT_POST, 'area')));
            $servico->setNome(filter_input(INPUT_POST, 'nome'));
            $servico->setDescricao(filter_input(INPUT_POST, 'descricao'));


            $servicoDAO->actualizar($servico);
            $redirector = new RedirectorHelper();
            $redirector->setUrlParameter('id', $servico->getId());
            $redirector->goToControllerAction('servico', 'ver');

            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function eliminarAction() {
        try {
            $servicoDAO = new ServicoDAO();

            $retorno = $servicoDAO->buscarID(filter_input(INPUT_POST, 'cod_servico'));
            if (!$retorno) {
                echo 'Não encontrou';
            }
            $servicoDAO->eliminar($retorno);
            $redirector = new RedirectorHelper();
            $redirector->goToControllerAction('servico', 'index');
            unset($redirector);
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    /**
     * @Método: imprimirPdfAction
     * @Descrição: Processa a impressão (pdf) da informação da área 
     * 
     */
    public function imprimirPdfAction() {
        try {
            $this->dados['entities'] = (new ServicoDAO())->listarTodos();
            $this->view('servico/RelatorioGeralPDF', $this->dados, ".php");
        } catch (Exception $exc) {
            $this->dados['mensagem'] = $exc->getMessage();
            $this->view('erro/erro', $this->dados);
        }
    }

    public function ajaxDevolveServicosAreaAction() {
        try {
            $servicos = (new ServicoDAO())->findByArea(filter_input(INPUT_POST, 'area'));
            $retorno = "";
            foreach ($servicos as $servico) {
                $retorno .= "<option value='" . $servico->getId() . "'>" . strtoupper($servico->getNome()) . "</option>";
            }
            echo ($retorno);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function ajaxDevolveServicosAreaExploracaoAction() {
        try {
            $servicos = (new ServicoDAO())->findByArea(filter_input(INPUT_POST, 'area'));
            $retorno = "";
            $retorno .= "<option value=''></option>";
            foreach ($servicos as $servico) {
                $retorno .= "<option value='" . $servico->getId() . "'>" . strtoupper($servico->getNome()) . "</option>";
            }
            echo ($retorno);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
