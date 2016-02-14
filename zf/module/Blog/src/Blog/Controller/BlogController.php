<?php
namespace Blog\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Blog\Model\Blog;          // <-- Add this import
 use Blog\Form\BlogForm;       // <-- Add this import
 
 
 
 class BlogController extends AbstractActionController
 {
	 public function getBlogTable()
     {
         if (@!$this->blogTable) {
             $sm = $this->getServiceLocator();
             $this->blogTable = $sm->get('Blog\Model\BlogTable');
         }
         return $this->blogTable;
     }
	 
     public function indexAction()
     {
		 return new ViewModel(array(
             'blogs' => $this->getBlogTable()->fetchAll(),
         ));

     }

    // Add content to this method:
     public function addAction()
     {
         $form = new BlogForm();
         $form->get('submit')->setValue('Add');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $blog = new Blog();
             $form->setInputFilter($blog->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $blog->exchangeArray($form->getData());
                 $this->getBlogTable()->saveBlog($blog);

                 // Redirect to list of Blogs
                 return $this->redirect()->toRoute('blog');
             }
         }
         return array('form' => $form);
     }

    // Add content to this method:
     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('blog', array(
                 'action' => 'add'
             ));
         }

         // Get the Blog with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
             $blog = $this->getBlogTable()->getBlog($id);
         }
         catch (\Exception $ex) {
             return $this->redirect()->toRoute('blog', array(
                 'action' => 'index'
             ));
         }

         $form  = new BlogForm();
         $form->bind($blog);
         $form->get('submit')->setAttribute('value', 'Edit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $form->setInputFilter($blog->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $this->getBlogTable()->saveBlog($blog);

                 // Redirect to list of Blogs
                 return $this->redirect()->toRoute('blog');
             }
         }

         return array(
             'id' => $id,
             'form' => $form,
         );
     }

     // Add content to the following method:
     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
             return $this->redirect()->toRoute('blog');
         }

         $request = $this->getRequest();
         if ($request->isPost()) {
             $del = $request->getPost('del', 'No');

             if ($del == 'Yes') {
                 $id = (int) $request->getPost('id');
                 $this->getBlogTable()->deleteBlog($id);
             }

             // Redirect to list of Blogs
             return $this->redirect()->toRoute('blog');
         }

         return array(
             'id'    => $id,
             'blog' => $this->getBlogTable()->getBlog($id)
         );
     }
	 
 }