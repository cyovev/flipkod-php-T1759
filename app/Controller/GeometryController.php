<?php
class GeometryController extends AppController {

    //////////////////////////////////////////////////////////////////////
    public function json() {
        $this->_disableView();
        
        try {
            $this->_includeModels();
            $type     = $this->request->params['type'];
            $response = $this->_processRequest($type);

            return json_encode($response);
        }
        catch (Exception $e) {
            $this->_displayErrorMessage($e->getMessage());
        }
    }

    //////////////////////////////////////////////////////////////////////
    protected function _includeModels() {
        $models = ['AppModel', 'Triangle', 'Circle'];
        foreach ($models as $model) {
            include_once(APP . 'Model' . DS . $model . '.php');
        }
    }

    //////////////////////////////////////////////////////////////////////
    // no view is needed, the response is in json format
    protected function _disableView() {
        $this->layout     = NULL;
        $this->autoRender = false;
    }

    //////////////////////////////////////////////////////////////////////
    protected function _displayErrorMessage($message) {
        header("HTTP/1.0 400 Bad Request");
        die($message);
    }

    //////////////////////////////////////////////////////////////////////
    protected function _processRequest($type) {
        switch ($type) {
            case 'circle':
                $response = $this->_processCircle();
                break;
            case 'triangle':
                $response = $this->_processTriangle();
                break;
        }

        // add the request type to the the beginning of the response
        $response = ['type' => $type] + $response;

        return $response;

    }

    //////////////////////////////////////////////////////////////////////
    protected function _processCircle() {
        $paramR        = $this->request->params['radius'];

        // initiate a circle with the given parameters
        $circle        = new Circle($paramR);
        $radius        = $circle->getRadius();
        $circumference = $circle->calculateCircumference();
        $surface       = $circle->calculateSurface();
        
        $resultArray   = [
            'radius'        => $this->_beautifyNumber($radius),
            'surface'       => $this->_beautifyNumber($surface),
            'circumference' => $this->_beautifyNumber($circumference),
        ];

        return $resultArray;

    }

    //////////////////////////////////////////////////////////////////////
    protected function _processTriangle() {
        $paramA   = $this->request->params['sidea'];
        $paramB   = $this->request->params['sideb'];
        $paramC   = $this->request->params['sidec'];
        
        // initiate a triangle with the given parameters
        $triangle         = new Triangle($paramA, $paramB, $paramC);
        list ($a, $b, $c) = $triangle->getSides();
        $circumference    = $triangle->calculateCircumference();
        $surface          = $triangle->calculateSurface();
        
        $resultArray      = [
            'a'             => $this->_beautifyNumber($a),
            'b'             => $this->_beautifyNumber($b),
            'c'             => $this->_beautifyNumber($c),
            'surface'       => $this->_beautifyNumber($surface),
            'circumference' => $this->_beautifyNumber($circumference),
        ];

        return $resultArray;
    }

    //////////////////////////////////////////////////////////////////////
    protected function _beautifyNumber($number) {
        return number_format($number, 2);
    }

}