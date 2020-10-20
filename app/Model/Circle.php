<?php
class Circle extends AppModel {

    private $radius;

    //////////////////////////////////////////////////////////////////////
    function __construct($r) {
        $this->radius     = (float) $r;
        $areParamsInvalid = (bool)  ($r == 0); // if after being casted the radius is 0, it's invalid

        if ($areParamsInvalid) {
            throw new Exception("Invalid radius");
        }
    }

    //////////////////////////////////////////////////////////////////////
    // there is a getRadius method because on construction the radius
    // gets casted to float which may result in different values for it
    public function getRadius() {
        return $this->radius;
    }

    //////////////////////////////////////////////////////////////////////
    public function calculateCircumference() {
        $circumference = pi() * $this->radius * 2;
        return $circumference;
    }

    //////////////////////////////////////////////////////////////////////
    public function calculateSurface() {
        $surface = pi() * $this->radius**2;
        return $surface;
    }

}