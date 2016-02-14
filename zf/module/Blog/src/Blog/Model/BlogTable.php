<?php
namespace Blog\Model;

 use Zend\Db\TableGateway\TableGateway;

 class BlogTable
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getBlog($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveBlog(Blog $blog)
     {
         $data = array(
             'artist' => $blog->artist,
             'title'  => $blog->title,
         );

         $id = (int) $blog->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getBlog($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Blog id does not exist');
             }
         }
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
	 public function deleteBlog($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
 }

