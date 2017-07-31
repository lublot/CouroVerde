<?php
require_once dirname(__FILE__).'/../../vendor/autoload.php';

use \PHPUnit\Framework\TestCase;
use \DAO\usuarioDAO as usuarioDAO;
use \DAO\noticiaDAO as noticiaDAO;
use \controllers\noticiasController as noticiasController;
use \exceptions\CampoNoticiaInvalidoException as CampoNoticiaInvalidoException;
use \exceptions\DadosCorrompidosException as DadosCorrompidosException;
use \exceptions\NoticiaNaoEncontradaException as NoticiaNaoEncontradaException;
use \models\Noticia as Noticia;

class noticiasControllerTest extends TestCase {
    private $instancia;


    public function setUp(){
        $this->instancia = new noticiasController(); //obtém instancia do controller
    
        //remove todas as noticias anteriormente cadastradas antes de realizar o teste
        $noticiaDAO = new NoticiaDAO();
        $noticiaDAO->remover(array("1"=>"1"));
    }

    /**
     * Testa o cadastro de uma notícia.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCadastrarNoticia() {
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticiasObtidas = $noticiaDAO->buscar(array(), array(
            "titulo" => 'Titulo 1',
            'descricao' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.',
            'subtitulo' => 'Subtitulo 1'
        ));

        $this->assertEquals(1, count($noticiasObtidas)); //verifica se apenas uma notícia foi encontrada
        
        $noticia = $noticiasObtidas[0];

        $this->assertEquals('Titulo 1', $noticia->getTitulo());
        $this->assertEquals('Subtitulo 1', $noticia->getSubtitulo());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', $noticia->getDescricao());
        $this->assertEquals(date('d/m/Y'), $noticia->getData()); //verifica se a data é a de hoje
        $this->assertNotFalse(strpos($noticia->getCaminhoImagem(), 'img1.gif')); //verifica se o caminho contém o nome da imagem

    }

    /**
     * Testa o cadastro de uma notícia com título inválido.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCadastrarNoticiaCampoTituloInvalido() {
        $this->instancia->configurarAmbienteParaTeste("", 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST');
        $this->expectException(CampoNoticiaInvalidoException::class); //exceção esperada
        $this->instancia->cadastrarNoticia();
    }    

    /**
     * Testa o cadastro de uma notícia sem subtítulo, já que esse campo é opcional.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCadastrarNoticiaSemSubtitulo() {
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', null, dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticiasObtidas = $noticiaDAO->buscar(array(), array(
            "titulo" => 'Titulo 1',
            'descricao' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.',
            'subtitulo' => null
        ));

        $this->assertEquals(1, count($noticiasObtidas)); //verifica se apenas uma notícia foi encontrada
        
        $noticia = $noticiasObtidas[0];

        $this->assertEquals('Titulo 1', $noticia->getTitulo());
        $this->assertEquals(null, $noticia->getSubtitulo());
        $this->assertEquals('Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', $noticia->getDescricao());
        $this->assertNotFalse(strpos($noticia->getCaminhoImagem(), 'img1.gif')); //verifica se o caminho contém o nome da imagem
    }

    /**
     * Testa o cadastro de uma notícia sem a variável super global POST estar setada com dados.      
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCadastrarNoticiaDadosCorrompidos() {
        $this->instancia->configurarAmbienteParaTeste(null, null, null, dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', null);
        $this->expectException(DadosCorrompidosException::class); //exceção esperada
        $this->instancia->cadastrarNoticia();
    }      


    /**
    * Testa a edição do titulo de uma notícia com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarNoticiaSucesso(){
        $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1','Subtitulo1',dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticia = $noticiaDAO->buscar(array(),array("titulo"=> "Titulo 1"));
        $idNoticia = $noticia[0]->getIdNoticia();
        $this->assertEquals(1,count($noticia));

        $tituloNovo = 'Titulo Novo';
        $this->instancia->configurarAmbienteParaTeste($tituloNovo,'Descricao 1','Subtitulo1',dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia',$idNoticia);
        $this->instancia->alterarNoticia();
        $noticia = $noticiaDAO->buscar(array(),array("titulo"=>$tituloNovo));
        $this->assertEquals(1,count($noticia));
    }

    /**
    * Testa a edição do subtitulo de uma notícia com sucesso;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarSubtituloNoticiaSucesso(){
         $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1','Subtitulo1',dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticia = $noticiaDAO->buscar(array(),array("titulo"=> "Titulo 1"));
        $idNoticia = $noticia[0]->getIdNoticia();
        $this->assertEquals(1,count($noticia));

        $subtituloNovo = 'Subtitulo Novo';
        $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1',$subtituloNovo,dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia',$idNoticia);
        $this->instancia->alterarNoticia();
        $noticia = $noticiaDAO->buscar(array(),array("subtitulo"=>$subtituloNovo));
        $this->assertEquals(1,count($noticia));
    }

    /**
    * Testa a edição de uma notícia com falha;
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testEditarNoticiaComFalha(){
        $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1','Subtitulo1',dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticia = $noticiaDAO->buscar(array(),array("titulo"=> "Titulo 1"));
        $idNoticia = $noticia[0]->getIdNoticia();
        $this->assertEquals(1,count($noticia));

        $subtituloNovo = 'Subtitulo Novo';
        $this->instancia->configurarAmbienteParaTeste('','Descricao 1',$subtituloNovo,dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia',$idNoticia);
        $this->expectException(CampoNoticiaInvalidoException::class); //exceção esperada        
        $this->instancia->alterarNoticia();
    }

    /**
    * Testa a remoção de uma notícia com sucesso
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testRemocaoComSucesso(){
        $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1','Subtitulo1',dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticia = $noticiaDAO->buscar(array(),array("titulo"=> "Titulo 1"));
        $idNoticia = $noticia[0]->getIdNoticia();
        $this->assertEquals(1,count($noticia));

        $subtituloNovo = 'Subtitulo Novo';
        $this->instancia->configurarAmbienteParaTeste('Titulo 1','Descricao 1',$subtituloNovo,dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif','img1.gif','Noticia',$idNoticia);
        $this->instancia->removerNoticia();

        $noticia = $noticiaDAO->buscar(array(),array("titulo"=> "Titulo 1"));
        $this->assertEquals(0,count($noticia));
    }

    /**
    * Testa a remoção com sucesso de uma notícia não cadastrada no sistema.
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testRemoverNoticiaNaoCadastrada() {
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST'); //configura o ambiente com o id default (0), que não possui uma noticia associada
        $this->expectException(NoticiaNaoEncontradaException::class); //exceção esperada        
        $this->instancia->removerNoticia();
    }        

    /**
    * Testa a busca de uma notícia com sucesso.
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testBuscarNoticiaSucesso() {
        //realiza o cadastro da pesquisa
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST');
        $this->instancia->cadastrarNoticia();

        $noticiaDAO = new NoticiaDAO();
        $noticiasObtidas = $noticiaDAO->buscar(array(), array(
            "titulo" => 'Titulo 1',
            'descricao' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.',
            'subtitulo' => 'Subtitulo 1'
        ));

        $this->assertEquals(1, count($noticiasObtidas)); //verifica se apenas uma notícia foi encontrada
        
        $noticia = $noticiasObtidas[0]; 

        //tenta realizar a busca após a realização do cadastro
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST', $noticia->getIdNoticia());
        $noticiaBuscada = $this->instancia->buscarNoticia();
        $this->assertTrue(isset($noticiaBuscada));
        $this->assertEquals($noticia->getIdNoticia(), $noticiaBuscada->getIdNoticia());       
    }

    /**
    * Testa a busca de uma notícia que não está cadastrada no sistema.
    * @runInSeparateProcess
    * @preserveGlobalState disabled    
    */
    public function testBuscarNoticiaNaoCadastrada() {
        $this->instancia->configurarAmbienteParaTeste('Titulo 1', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Similique beatae et reprehenderit cumque quisquam in fuga blanditiis. Tenetur assumenda porro, quidem ut, totam earum. Quos cupiditate commodi eveniet dolorem, incidunt.', 'Subtitulo 1', dirname(dirname(dirname(__FILE__))).'/test/imgTest/img1.gif', 'img1.gif', 'POST'); //o id está definido por default como 0 e não existe no sistema
        $this->expectException(NoticiaNaoEncontradaException::class); //exceção esperada        
        $noticiaBuscada = $this->instancia->buscarNoticia();   
    }

}