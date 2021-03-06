<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Validation_admin implements FilterInterface
{
    protected $session;

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();
        if(!$this->session->has('username'))
        {
            return redirect()->route('auth');
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
       
    }
    
}
