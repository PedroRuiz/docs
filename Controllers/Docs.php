<?php

namespace Docs\Controllers;

use App\Controllers\BaseController;

class Docs extends BaseController
{
  protected $ModelDocuments;

  function __construct()
  {
    $this->ModelDocuments = new \Docs\Models\Docs();
    helper('form','url');
  }

  public function index()
  {
    
    if($this->request->getPost())
    {
      $haveId     = $this->request->getPost('id') !== '' ? true : false;
      $haveTitle  = $this->request->getPost('title') !== '' ? true : false;

      if(!$haveId && !$haveTitle)
      {
        $document             = $this->request->getPost();
        $document['user']     = $_SESSION['user']['id'];
        $document['docname']  = lang('docsModule.documentPrefix') . date('Ymd_His');
        $document['content']  = $this->request->getPost('editor1');

        /**
         * data to sweetAlert
         * 
         * if success i+ else i-
         */
        if($document['id'] = $this->ModelDocuments->insert($document))
        {
          $this->session->setFlashdata('flash', 'i+'); 
        }
        else
        {
          $this->session->setFlashdata('flash', 'i-');
        }

      }
      else 
      {
        $document             = $this->request->getPost();
        $document['user']     = $_SESSION['user']['id'];
        $document['docname']  = $this->request->getPost('title');
        $document['content']  = $this->request->getPost('editor1');
        $document['id']       = $this->request->getPost('id');
        $document['title']    = $this->request->getPost('title');
        
        /**
         * data to sweetAlert
         * 
         * if success u+ else u-
         */
        if($this->ModelDocuments->update($document['id'],$document))
        {
          $this->session->setFlashdata('flash', 'u+');
        }
        else
        {
          $this->session->setFlashdata('flash', 'u-');
        }
      }

      
    }
        
    return view('Docs\Views\index',[
      'docsModuleMenuOpen'      => true,
      'docsModuleEditorActive'  => true,
      'content'                 => $this->request->getPost('editor1') ?? null,      
      'hiden'                   => [
        'id'      => $document['id'] ?? '',
        'title'   => $document['docname'] ?? '',
      ]
    ]);
  }

  public function list()
  {
    helper('text');
    $ionAuth     = new \IonAuth\Libraries\IonAuth();
    if($_SESSION['user']['isAdmin'] === false)
    {
      $documents = $this->ModelDocuments->where('user',$_SESSION['user']['id'])->findAll();      
    }
    else 
    {
      $docs = $this->ModelDocuments->findAll();

      foreach($docs as $document)
      {
        $user = (array) $ionAuth->user($document['user'])->row();
        
        $username = sprintf('%s %s',$user['first_name'], $user['last_name']);
        $document['username'] = $username;

        $documents[] = $document;
      }
    }

    

    return view('Docs\Views\list',[
      'docsModuleMenuOpen'      => true,
      'docsModuleDocsList'      => true,
      'documents'               => $documents ?? []
    ]);
  }

  public function listDocument(int $idDoc)
  {

    if($this->request->getPost())
    {
      
        $document             = $this->request->getPost();
        $document['user']     = $_SESSION['user']['id'];
        $document['docname']  = $this->request->getPost('title');
        $document['content']  = $this->request->getPost('editor1');
        $document['id']       = $this->request->getPost('id');
        $document['title']    = $this->request->getPost('title');
        
        /**
         * data to sweetAlert
         * 
         * if success u+ else u-
         */
        if($this->ModelDocuments->update($document['id'],$document))
        {
          $this->session->setFlashdata('flash', 'u+');
        }
        else
        {
          $this->session->setFlashdata('flash', 'u-');
        }            
    }

    $document = $this->ModelDocuments->where('id',$idDoc)->first();

    if(empty($document)) return redirect()->back()->with('flash','r-');

    if(!$_SESSION['user']['isAdmin'])
    {
      $privilege = ($document['user']===$_SESSION['user']['id']) ? true : false;
    }
    else
    {
      $privilege = true;
    }

    if($privilege)
    {
      return view('Docs\Views\index',[
        'docsModuleMenuOpen'      => true,
        'docsModuleEditorActive'  => true,
        'content'                 => $document['content'],      
        'hiden'                   => [
          'id'      => $document['id'] ?? '',
          'title'   => $document['docname'] ?? '',
        ]
      ]);
    }
    else
    {
      return redirect()->back()->with('flash','np');
    }
  }

  public function renameDocument()
  {
    $data = $this->request->getPost(); 


    if($this->ModelDocuments->update($data['documentId'],['docname' => $data['newName'] ]))
    {
      header('Content-Type: text/html; charset=utf-8');
      return $this->response->setJson(json_encode($data));    
    }
    else
    {
      header('HTTP/1.1 500 Internal Server Booboo');
      header('Content-Type: application/json; charset=UTF-8');
      die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }
    
  }

  public function deleteDocument()
  {
    $data = $this->request->getPost(); 


    if($this->ModelDocuments->delete($data['documentId']))
    {
      header('Content-Type: text/html; charset=utf-8');
      return $this->response->setJson(json_encode($data));    
    }

  }


}
