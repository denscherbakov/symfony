<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBaseController extends AbstractController
{
    /**
    * @return string[]
    */
    public function renderDefault(): array
    {
        return [
            'title' => 'Admin part',
        ];
    }
}
