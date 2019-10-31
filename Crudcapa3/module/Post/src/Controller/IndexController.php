<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Post\Controller;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Form;
use Zend\Db\TableGateway\TableGatewayInterface;
use Post\Services\PostServices;
use Post\Model\PostTable;
use Post\Model\Post;
use Post\Form\PostForm;


class IndexController extends AbstractActionController
{
      private $postServices;
    
    public function __construct(){ 
           $this->postServices = new PostServices();
    }
    public function indexAction(){
        $posts = $this->postServices->fetchAll();         
        return new ViewModel(['posts'=>$posts ]);
    }

	public function addAction(){        
      $form = new \Post\Form\PostForm;
            //agregacion de validacion
        if ($this->getRequest()->isPost()) {
            # recuperar datos
            $formData = $this->getRequest()->getPost();
            //imprime
            //echo "<pre>"; print_r($formData);exit;
            $post = $this->postServices->addAction($formData);
                if ($post) {
                    # valida que la variable tenga algo para regresarlo.
                    $this->redirect()->toUrl($this->getRequest()->getBAseUrl().'/post/index');
                }
        }
        return array('form'=>$form);
        
    }
    
    public function viewAction(){ 
        $id =(int) $this->params()->fromRoute('id', 0);
        if($id == 0){
            exit('Error');
        }
        try{
            $post = $this->table->getPost($id);
        }
            catch(Exception $e){
                exit('Error');
            }       
            return new ViewModel(['post' => $post, 'id' => $id]);
    }




    public function editAction(){
        $form = new PostForm();
        $id = $this->params()->fromRoute("id");
        //echo $id_user; exit;
        $post = $this->postServices->getUserById($id);
        //carga los valores al formulario
        //print_r($post);exit();
        $form-> setData($post);
        //para que nos muestre el formulario
        if ($this->getRequest()->isPost()) {
            # recuperar datos
            $formData = $this->getRequest()->getPost();
            //imprime
            //echo "<pre>"; print_r($formData);exit;
            $post = $this->postServices->editAction($formData);
                if ($post) {
                    # valida que la variable tenga algo para regresarlo.
                    return array('form'=>$form, 'mensaje' => "Mascota actualizada correctamente");
                    /*$this->redirect()->toUrl($this->getRequest()->getBAseUrl().'/post/index');*/
                }
        }
        return array('form'=>$form, 'mensaje' => "");
        }

        public function deleteAction(){
        $id = $this->params()->fromRoute("id");
        $post = $this->postServices->deleteAction($id);
        //redirecciona al index del listado.
        return $this->redirect()->toUrl($this->getRequest()->getBaseUrl().'/post/index');
    }

}


        
