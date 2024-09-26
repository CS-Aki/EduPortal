<?php 

class Controller extends User{
    
    //Create a function to pass in as arguments to the model function
    //After receiving data from model, pass it into viewer
    //If error occurs, it'll still send error signal to viewer
    public function fetchUser(){     
        $view = new View();
        $result = $this->getUser();
        return $view->showUser($result);
    }
    
}