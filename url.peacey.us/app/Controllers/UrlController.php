<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Url;

class UrlController extends Controller
{
    public function landing()
    {
        // 1) Instantiate the model
        $model = new Url();
        
        // 2) Pull in whatever data the model provides
        $data = $model->getLandingData();
        
        // 3) Render the view, handing it the data
        $this->view('url/landing', ['data' => $data]);
    }
}
