<?php

namespace Amcb\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Process\Process;

class AdminController extends Controller
{

    public function cacheClearAction()
    {
        $process = new Process('php ../app/console cache:clear --env=prod');
        $process->run();
        
        return $this->redirect($this->generateUrl('admin_index'));
    }   
}
?>
